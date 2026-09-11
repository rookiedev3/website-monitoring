<?php

namespace App\Jobs;

use App\Models\MonitoringLog;
use App\Models\MonitoringSetting;
use App\Models\Website;
use App\Services\IncidentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CheckWebsiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;

    public function __construct(public Website $website) {}

    public function handle(): void
    {
        // 0. CEK KEBERADAAN DATA & CACHE LOCK
        if (! $this->website->exists) {
            return;
        }

        // Mencegah job berjalan ganda untuk website yang sama secara bersamaan
        $lock = Cache::lock('checking_website_'.$this->website->id, 25);
        if (! $lock->get()) {
            return;
        }

        try {
            // 1. AMBIL GLOBAL SETTINGS DENGAN CACHE (1 JAM)
            $settings = Cache::remember('global_monitoring_settings', 3600, function () {
                return MonitoringSetting::first()?->only([
                    'slow_threshold_ms',
                    'ssl_warning_days',
                    'timeout_seconds',
                ]);
            });

            $slowThreshold = $settings['slow_threshold_ms'] ?? 2000;
            $sslWarningDays = $settings['ssl_warning_days'] ?? 14;
            $timeoutSeconds = $this->website->timeout_seconds ?? ($settings['timeout_seconds'] ?? 10);

            $startTime = microtime(true);
            $url = $this->website->url;

            $status = 'online';
            $incidentType = null;
            $httpCode = null;
            $errorType = null;
            $errorMessage = null;
            $responseTimeMs = null;

            // --- 2. PROSES PENGECEKAN HTTP CLIENT (APPLICATION LAYER) ---
            try {
                $response = Http::timeout($timeoutSeconds)
                    ->withOptions(['verify' => false])
                    ->get($url);

                $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
                $httpCode = $response->status();

                if ($response->successful()) {
                    if ($responseTimeMs > $slowThreshold) {
                        $status = 'warning';
                        $incidentType = 'slow';
                    }
                } else {
                    $status = 'down';
                    $incidentType = 'http_error';
                    $errorType = 'HTTP_SERVER_ERROR';
                    $errorMessage = "Server merespons dengan HTTP status: {$httpCode}";
                }
            } catch (ConnectionException $e) {
                $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
                $status = 'down';

                if (str_contains(strtolower($e->getMessage()), 'timed out')) {
                    $incidentType = 'timeout';
                    $errorType = 'CONNECTION_TIMEOUT';
                } else {
                    $incidentType = 'down';
                    $errorType = 'CONNECTION_FAILED';
                }
                $errorMessage = $e->getMessage();
            } catch (\Throwable $e) {
                $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
                $status = 'down';
                $incidentType = 'down';
                $errorType = 'UNKNOWN_ERROR';
                $errorMessage = $e->getMessage();
            }

            // --- 3. PROSES DIAGNOSTIK PING (NETWORK LAYER) ---
            // Hanya dijalankan jika koneksi HTTP gagal total / timeout
            if ($status === 'down' && in_array($incidentType, ['down', 'timeout'])) {
                $pingResult = $this->executePing($url, $timeoutSeconds);
                if (! $pingResult['success']) {
                    $errorMessage = ($errorMessage ? $errorMessage.' | ' : '').$pingResult['error'];
                }
            }

            // --- 4. CEK SSL CERTIFICATE (JIKA WEBSITE TIDAK DOWN) ---
            $sslInfo = $this->checkSslCertificate($url, $timeoutSeconds);

            if ($sslInfo['valid'] !== null && $status !== 'down') {
                if (! $sslInfo['valid']) {
                    $status = 'ssl_error';
                    $incidentType = 'ssl';
                    $errorType = 'SSL_INVALID';
                    $errorMessage = $sslInfo['error'] ?? 'Sertifikat SSL tidak valid atau telah kadaluwarsa';
                } elseif ($sslInfo['days_left'] <= $sslWarningDays) {
                    $status = 'ssl_error';
                    $incidentType = 'ssl';
                    $errorType = 'SSL_EXPIRING_SOON';
                    $errorMessage = "SSL akan kadaluwarsa dalam {$sslInfo['days_left']} hari";
                }
            }

            $now = Carbon::now();

            // --- 5. REKAM HASIL KE TABEL monitoring_logs ---
            MonitoringLog::create([
                'website_id' => $this->website->id,
                'status' => $status,
                'http_code' => $httpCode,
                'response_time_ms' => $responseTimeMs,
                'ssl_valid' => $sslInfo['valid'],
                'ssl_expired_at' => $sslInfo['expired_at'],
                'ssl_days_left' => $sslInfo['days_left'],
                'error_type' => $errorType,
                'error_message' => $errorMessage,
                'checked_at' => $now,
            ]);

            // Sinkronkan status terakhir ke tabel websites
            $this->website->update([
                'last_status' => $status,
            ]);

            // --- 6. OTOMATISASI INCIDENT LIFECYCLE ---
            app(IncidentService::class)->evaluate($this->website, $status, $incidentType);

        } finally {
            // Selalu lepas lock setelah proses selesai
            $lock->release();
        }
    }

    /**
     * Helper untuk mengeksekusi sistem Ping (ICMP) berdasarkan OS
     *
     * @return array{success: bool, error: ?string}
     */
    private function executePing(string $url, int $timeoutSeconds): array
    {
        if (app()->environment('testing')) {
            return [
                'success' => true,
                'error' => null,
            ];
        }

        $host = parse_url($url, PHP_URL_HOST);
        if (! $host) {
            $host = preg_replace('#^https?://#i', '', $url);
            $host = explode('/', $host)[0];
            $host = explode(':', $host)[0];
        }

        if (empty($host)) {
            return [
                'success' => false,
                'error' => 'Host tidak valid untuk ping',
            ];
        }

        $timeout = max(1, min($timeoutSeconds, 3));

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $timeoutMs = $timeout * 1000;
            $command = sprintf('ping -n 1 -w %d %s', $timeoutMs, escapeshellarg($host));
        } else {
            $command = sprintf('ping -c 1 -W %d %s', $timeout, escapeshellarg($host));
        }

        exec($command, $output, $resultCode);
        $outputStr = implode(' ', $output ?? []);

        $isLost = str_contains($outputStr, '100% loss')
            || str_contains($outputStr, 'Request timed out')
            || str_contains($outputStr, 'Destination host unreachable')
            || str_contains($outputStr, 'could not find host')
            || str_contains($outputStr, 'tidak dapat menemukan host');

        if ($resultCode === 0 && ! $isLost) {
            return [
                'success' => true,
                'error' => null,
            ];
        }

        return [
            'success' => false,
            'error' => "Ping ke host '{$host}' gagal (Packet Loss / Unreachable)",
        ];
    }

    /**
     * Helper untuk memeriksa validitas dan sisa masa aktif sertifikat SSL
     *
     * @return array{valid: ?bool, expired_at: ?Carbon, days_left: ?int, error: ?string}
     */
    private function checkSslCertificate(string $url, int $timeoutSeconds = 5): array
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (strtolower($scheme ?? '') !== 'https') {
            return [
                'valid' => null,
                'expired_at' => null,
                'days_left' => null,
                'error' => null,
            ];
        }

        $host = parse_url($url, PHP_URL_HOST);
        if (! $host) {
            return [
                'valid' => false,
                'expired_at' => null,
                'days_left' => 0,
                'error' => 'Format domain host tidak valid',
            ];
        }

        $port = parse_url($url, PHP_URL_PORT) ?? 443;
        $timeout = max(2, min($timeoutSeconds, 10));

        $gcontext = stream_context_create([
            'ssl' => [
                'capture_peer_cert' => true,
                'verify_peer' => false,
                'verify_peer_name' => false,
                'SNI_enabled' => true,
                'peer_name' => $host,
                'allow_self_signed' => true,
            ],
        ]);

        $client = @stream_socket_client(
            "ssl://{$host}:{$port}",
            $errno,
            $errstr,
            $timeout,
            STREAM_CLIENT_CONNECT,
            $gcontext
        );

        if (! $client) {
            return [
                'valid' => false,
                'expired_at' => null,
                'days_left' => 0,
                'error' => $errstr ?: 'Gagal terhubung ke port SSL 443',
            ];
        }

        $cont = stream_context_get_params($client);
        $peerCert = $cont['options']['ssl']['peer_certificate'] ?? null;
        $cert = $peerCert ? openssl_x509_parse($peerCert) : null;

        fclose($client);

        if (! $cert || ! isset($cert['validTo_time_t'])) {
            return [
                'valid' => false,
                'expired_at' => null,
                'days_left' => 0,
                'error' => 'Sertifikat SSL tidak valid atau tidak dapat dibaca',
            ];
        }

        $validTo = Carbon::createFromTimestamp($cert['validTo_time_t']);
        $validFrom = isset($cert['validFrom_time_t']) ? Carbon::createFromTimestamp($cert['validFrom_time_t']) : null;
        $now = Carbon::now();
        $daysLeft = (int) $now->diffInDays($validTo, false);

        if ($validFrom && $now->lt($validFrom)) {
            return [
                'valid' => false,
                'expired_at' => $validTo,
                'days_left' => $daysLeft,
                'error' => 'Sertifikat SSL belum aktif',
            ];
        }

        if ($now->gt($validTo) || $daysLeft < 0) {
            return [
                'valid' => false,
                'expired_at' => $validTo,
                'days_left' => $daysLeft,
                'error' => 'Sertifikat SSL telah kadaluwarsa',
            ];
        }

        return [
            'valid' => true,
            'expired_at' => $validTo,
            'days_left' => $daysLeft,
            'error' => null,
        ];
    }
}

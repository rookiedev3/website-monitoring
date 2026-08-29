<?php

namespace App\Jobs;

use App\Models\Website;
use App\Models\MonitoringLog;
use App\Models\Incident;
use App\Models\MonitoringSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class CheckWebsiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;

    public function __construct(public Website $website)
    {
    }

    public function handle(): void
    {
        // 0. AMBIL GLOBAL SETTINGS DENGAN CACHE (1 JAM)
        $settings = Cache::remember('global_monitoring_settings', 3600, function () {
            return MonitoringSetting::first();
        });

        // Tentukan batas threshold dinamis (dengan fallback default jika DB kosong)
        $slowThreshold = $settings->slow_threshold_ms ?? 2000;
        $sslWarningDays = $settings->ssl_warning_days ?? 14;
        // Mengambil timeout kustom milik website, jika null pakai global setting
        $timeoutSeconds = $this->website->timeout_seconds ?? ($settings->timeout_seconds ?? 10);


        $startTime = microtime(true);
        $url = $this->website->url;

        // Digunakan sebagai batas HTTP Client Request
        $response = Http::timeout($timeoutSeconds)
            ->withOptions(['verify' => false])
            ->get($url);

        $status = 'online';
        $incidentType = null;
        $httpCode = null;
        $errorType = null;
        $errorMessage = null;

        // --- 1. PROSES PENGECEKAN HTTP CLIENT ---
        try {
            // bypass SSL verify di cURL agar error SSL ditangani terpisah
            $response = Http::timeout($timeoutSeconds)
                ->withOptions(['verify' => false])
                ->get($url);

            $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
            $httpCode = $response->status();

            if ($response->successful()) {
                // Menggunakan slow_threshold_ms dinamis dari MonitoringSetting
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
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
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
        } catch (\Exception $e) {
            $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
            $status = 'down';
            $incidentType = 'down';
            $errorType = 'UNKNOWN_ERROR';
            $errorMessage = $e->getMessage();
        }

        // --- 2. CEK SSL CERTIFICATE (JIKA TIDAK DOWN) ---
        $sslInfo = $this->checkSslCertificate($url);

        // Menggunakan ssl_warning_days dinamis dari MonitoringSetting
        if ((!$sslInfo['valid'] || $sslInfo['days_left'] <= $sslWarningDays) && $status !== 'down') {
            $status = 'ssl_error';
            $incidentType = 'ssl';
            $errorType = 'SSL_INVALID';
            $errorMessage = $sslInfo['error'] ?? "SSL Kadaluwarsa dalam {$sslInfo['days_left']} hari";
        }

        $now = Carbon::now();

        // --- 3. REKAM HASIL KE TABEL monitoring_logs ---
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

        $this->website->touch();

        // --- 4. OTOMATISASI INCIDENT LIFECYCLE ---
        $this->handleIncidentLifecycle($status, $incidentType, $now);
    }

    private function checkSslCertificate(string $url): array
    {
        $host = parse_url($url, PHP_URL_HOST) ?? $url;

        $gcontext = stream_context_create(["ssl" => ["capture_peer_cert" => true]]);
        $client = @stream_socket_client("ssl://{$host}:443", $errno, $errstr, 5, STREAM_CLIENT_CONNECT, $gcontext);

        if (!$client) {
            return [
                'valid' => false,
                'expired_at' => null,
                'days_left' => 0,
                'error' => $errstr ?: 'Gagal terhubung ke port SSL 443',
            ];
        }

        $cont = stream_context_get_params($client);
        $cert = isset($cont["options"]["ssl"]["peer_certificate"])
            ? openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"])
            : null;

        fclose($client);

        if (!$cert) {
            return [
                'valid' => false,
                'expired_at' => null,
                'days_left' => 0,
                'error' => 'Sertifikat SSL tidak valid / tidak terbaca',
            ];
        }

        $validTo = Carbon::createFromTimestamp($cert['validTo_time_t']);
        $daysLeft = (int) Carbon::now()->diffInDays($validTo, false);

        return [
            'valid' => $daysLeft > 0,
            'expired_at' => $validTo,
            'days_left' => $daysLeft,
            'error' => $daysLeft <= 0 ? 'Sertifikat SSL telah kadaluwarsa' : null,
        ];
    }

    private function handleIncidentLifecycle(string $status, ?string $incidentType, Carbon $now): void
    {
        $activeIncident = Incident::where('website_id', $this->website->id)
            ->whereIn('status', ['open', 'on_progress'])
            ->latest()
            ->first();

        // Jika Web bermasalah (down / ssl_error) & belum ada insiden aktif
        if (in_array($status, ['down', 'ssl_error']) && !$activeIncident) {
            Incident::create([
                'website_id' => $this->website->id,
                'incident_type' => $incidentType ?? 'down',
                'status' => 'open',
                'started_at' => $now,
            ]);
        }
        // Jika Web kembali normal & ada insiden aktif
        elseif ($status === 'online' && $activeIncident) {
            $durationInSeconds = $activeIncident->started_at->diffInSeconds($now);

            $activeIncident->update([
                'status' => 'solved',
                'resolved_at' => $now,
                'duration_seconds' => $durationInSeconds,
            ]);
        }
    }
}
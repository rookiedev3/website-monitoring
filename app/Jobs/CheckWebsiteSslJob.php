<?php

namespace App\Jobs;

use App\Models\MonitoringLog;
use App\Models\MonitoringSetting;
use App\Models\Website;
use App\Services\IncidentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class CheckWebsiteSslJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;

    public function __construct(public Website $website) {}

    public function handle(): void
    {
        if (! $this->website->exists) {
            return;
        }

        if ($this->website->monitoring_status === 'paused') {
            return;
        }

        $lock = Cache::lock('checking_website_ssl_'.$this->website->id, 25);
        if (! $lock->get()) {
            return;
        }

        try {
            $settings = Cache::remember('global_monitoring_settings', 3600, function () {
                return MonitoringSetting::first()?->only(['ssl_warning_days']);
            });

            $sslWarningDays = $settings['ssl_warning_days'] ?? 14;
            $url = $this->website->url;

            $sslInfo = $this->checkSslCertificate($url, 5);

            $status = 'online';
            $incidentType = null;
            $errorType = null;
            $errorMessage = null;

            if ($sslInfo['valid'] !== null) {
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

            // Simpan status SSL ke cache agar cepat diakses oleh HTTP Job dan Dashboard
            Cache::put("website_ssl_info_{$this->website->id}", [
                'ssl_valid' => $sslInfo['valid'],
                'ssl_expired_at' => $sslInfo['expired_at']?->toIso8601String(),
                'ssl_days_left' => $sslInfo['days_left'],
                'error' => $errorMessage,
            ], now()->addDays(2));

            // Rekam hasil pengecekan SSL ke MonitoringLog
            MonitoringLog::create([
                'website_id' => $this->website->id,
                'status' => $status,
                'ssl_valid' => $sslInfo['valid'],
                'ssl_expired_at' => $sslInfo['expired_at'],
                'ssl_days_left' => $sslInfo['days_left'],
                'error_type' => $errorType,
                'error_message' => $errorMessage,
                'checked_at' => Carbon::now(),
            ]);

            if ($incidentType !== null) {
                app(IncidentService::class)->evaluate($this->website, $status, $incidentType);
            }

        } finally {
            $lock->release();
        }
    }

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

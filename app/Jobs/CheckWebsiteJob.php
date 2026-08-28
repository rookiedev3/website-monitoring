<?php

namespace App\Jobs;

use App\Models\Website;
use App\Models\MonitoringLog;
use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;

class CheckWebsiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Set timeout eksekusi Job di Queue Worker (dalam detik)
     */
    public $timeout = 30;

    public function __construct(public Website $website) {}

    public function handle(): void
    {
        $startTime = microtime(true);
        $url = $this->website->url;
        // Ambil timeout khusus dari database website (default 10s jika kosong)
        $timeoutSeconds = $this->website->timeout_seconds ?? 10;
        
        $status = 'online';
        $incidentType = null;
        $httpCode = null;
        $errorType = null;
        $errorMessage = null;

        // --- 1. PROSES PENGECEKAN HTTP CLIENT ---
        try {
            $response = Http::timeout($timeoutSeconds)->get($url);
            $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
            $httpCode = $response->status();

            if ($response->successful()) {
                if ($responseTimeMs > 3000) { // Threshold 3 detik (Slow)
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
            
            // Deteksi jenis error: Timeout vs Gagal Koneksi
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
        if (!$sslInfo['valid'] && $status !== 'down') {
            $status = 'ssl_error';
            $incidentType = 'ssl';
            $errorType = 'SSL_INVALID';
            $errorMessage = $sslInfo['error'];
        }

        $now = Carbon::now();

        // --- 3. REKAM HASIL KE TABEL monitoring_logs ---
        MonitoringLog::create([
            'website_id'       => $this->website->id,
            'status'           => $status,
            'http_code'        => $httpCode,
            'response_time_ms' => $responseTimeMs,
            'ssl_valid'        => $sslInfo['valid'],
            'ssl_expired_at'   => $sslInfo['expired_at'],
            'ssl_days_left'    => $sslInfo['days_left'],
            'error_type'       => $errorType,
            'error_message'    => $errorMessage,
            'checked_at'       => $now,
        ]);

        // Perbarui timestamp updated_at pada master website
        $this->website->touch();

        // --- 4. OTOMATISASI INCIDENT LIFECYCLE ---
        $this->handleIncidentLifecycle($status, $incidentType, $now);
    }

    /**
     * Memeriksa Keabsahan dan Masa Berlaku Sertifikat SSL
     */
    private function checkSslCertificate(string $url): array
    {
        $host = parse_url($url, PHP_URL_HOST) ?? $url;
        
        $gcontext = stream_context_create(["ssl" => ["capture_peer_cert" => true]]);
        $client = @stream_socket_client("ssl://{$host}:443", $errno, $errstr, 5, STREAM_CLIENT_CONNECT, $gcontext);

        if (!$client) {
            return [
                'valid'      => false,
                'expired_at' => null,
                'days_left'  => null,
                'error'      => $errstr ?: 'Gagal terhubung ke port SSL 443',
            ];
        }

        $cont = stream_context_get_params($client);
        $cert = openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"]);
        fclose($client);

        if (!$cert) {
            return [
                'valid'      => false,
                'expired_at' => null,
                'days_left'  => null,
                'error'      => 'Sertifikat SSL tidak valid / tidak terbaca',
            ];
        }

        $validTo = Carbon::createFromTimestamp($cert['validTo_time_t']);
        $daysLeft = (int) Carbon::now()->diffInDays($validTo, false);

        return [
            'valid'      => $daysLeft > 0,
            'expired_at' => $validTo,
            'days_left'  => $daysLeft,
            'error'      => $daysLeft <= 0 ? 'Sertifikat SSL telah kadaluwarsa' : null,
        ];
    }

    /**
     * Otomatis membuat insiden baru jika down/ssl_error & menutup insiden jika web kembali normal
     */
    private function handleIncidentLifecycle(string $status, ?string $incidentType, Carbon $now): void
    {
        // Cari insiden aktif yang belum selesai
        $activeIncident = Incident::where('website_id', $this->website->id)
            ->whereIn('status', ['open', 'on_progress'])
            ->latest()
            ->first();

        // 1. Jika Web bermasalah & belum ada insiden aktif -> Buat Insiden Baru
        if (in_array($status, ['down', 'ssl_error']) && !$activeIncident) {
            Incident::create([
                'website_id'    => $this->website->id,
                'incident_type' => $incidentType ?? 'down',
                'status'        => 'open',
                'started_at'    => $now,
            ]);
        } 
        // 2. Jika Web kembali normal & ada insiden aktif -> Auto Solve & Hitung Durasi (detik)
        elseif ($status === 'online' && $activeIncident) {
            $durationInSeconds = $activeIncident->started_at->diffInSeconds($now);

            $activeIncident->update([
                'status'           => 'solved',
                'resolved_at'      => $now,
                'duration_seconds' => $durationInSeconds,
            ]);
        }
    }
}
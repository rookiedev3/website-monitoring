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

    public function __construct(public Website $website) {}

    public function handle(): void
    {
        $startTime = microtime(true);
        $url = $this->website->url;
        
        $status = 'online';
        $incidentType = null;
        $httpCode = null;
        $errorType = null;
        $errorMessage = null;

        // --- 1. PROSES PENGECEKAN HTTP ---
        try {
            $response = Http::timeout(10)->get($url);
            $responseTimeMs = round((microtime(true) - $startTime) * 1000);
            $httpCode = $response->status();

            if ($response->successful()) {
                if ($responseTimeMs > 3000) { // Threshold 3 detik
                    $status = 'warning';
                    $incidentType = 'slow'; // Sesuai enum 'slow' di migrasimu
                }
            } else {
                $status = 'down';
                $incidentType = 'http_error'; // Sesuai enum 'http_error'
                $errorType = 'HTTP_SERVER_ERROR';
                $errorMessage = "HTTP status code: {$httpCode}";
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $responseTimeMs = round((microtime(true) - $startTime) * 1000);
            $status = 'down';
            
            // Cek apakah murni timeout atau gagal koneksi
            $incidentType = str_contains($e->getMessage(), 'timed out') ? 'timeout' : 'down';
            $errorType = 'CONNECTION_FAILED';
            $errorMessage = $e->getMessage();
        } catch (\Exception $e) {
            $responseTimeMs = round((microtime(true) - $startTime) * 1000);
            $status = 'down';
            $incidentType = 'down';
            $errorType = 'UNKNOWN_ERROR';
            $errorMessage = $e->getMessage();
        }

        // --- 2. CEK SSL (JIKA TIDAK DOWN) ---
        $sslInfo = $this->checkSslCertificate($url);
        if (!$sslInfo['valid'] && $status !== 'down') {
            $status = 'ssl_error';
            $incidentType = 'ssl'; // Sesuai enum 'ssl'
            $errorType = 'SSL_INVALID';
            $errorMessage = $sslInfo['error'];
        }

        $now = Carbon::now();

        // --- 3. SIMPAN KE TABEL monitoring_logs ---
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

        // Update status terkini di master website
        $this->website->update([
            'last_checked_at' => $now,
            'current_status'  => $status
        ]);

        // --- 4. KELOLA LIFECYCLE INCIDENT ---
        $this->handleIncidentLifecycle($status, $incidentType, $now);
    }

    private function checkSslCertificate(string $url): array
    {
        $host = parse_url($url, PHP_URL_HOST) ?? $url;
        $gcontext = stream_context_create(["ssl" => ["capture_peer_cert" => true]]);
        $client = @stream_socket_client("ssl://{$host}:443", $errno, $errstr, 5, STREAM_CLIENT_CONNECT, $gcontext);

        if (!$client) {
            return ['valid' => false, 'expired_at' => null, 'days_left' => null, 'error' => $errstr];
        }

        $cont = stream_context_get_params($client);
        $cert = openssl_x509_parse($cont["options"]["ssl"]["peer_certificate"]);
        fclose($client);

        if (!$cert) {
            return ['valid' => false, 'expired_at' => null, 'days_left' => null, 'error' => 'Sertifikat SSL tidak valid'];
        }

        $validTo = Carbon::createFromTimestamp($cert['validTo_time_t']);
        $daysLeft = (int) Carbon::now()->diffInDays($validTo, false);

        return [
            'valid'      => $daysLeft > 0,
            'expired_at' => $validTo,
            'days_left'  => $daysLeft,
            'error'      => $daysLeft <= 0 ? 'SSL expired' : null,
        ];
    }

    private function handleIncidentLifecycle(string $status, ?string $incidentType, Carbon $now): void
    {
        // Cari insiden yang belum selesai (open / on_progress)
        $activeIncident = Incident::where('website_id', $this->website->id)
            ->whereIn('status', ['open', 'on_progress'])
            ->latest()
            ->first();

        // 1. Jika Web bermasalah & belum ada insiden aktif -> Bikin Insiden Baru
        if (in_array($status, ['down', 'ssl_error']) && !$activeIncident) {
            Incident::create([
                'website_id'    => $this->website->id,
                'incident_type' => $incidentType ?? 'down',
                'status'        => 'open',
                'started_at'    => $now,
            ]);
        } 
        // 2. Jika Web sudah kembali normal & ada insiden aktif -> Auto Solve & Hitung Detik
        elseif ($status === 'online' && $activeIncident) {
            $durationInSeconds = $activeIncident->started_at->diffInSeconds($now);

            $activeIncident->update([
                'status'           => 'solved',
                'resolved_at'      => $now,
                'duration_seconds' => $durationInSeconds, // Menyimpan durasi presisi dalam detik
            ]);
        }
    }
}
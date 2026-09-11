<?php

namespace App\Jobs;

use App\Models\Website;
use App\Services\PingHistoryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

/**
 * Job ini dipanggil sangat sering (idealnya tiap detik). Untuk shared hosting
 * tanpa Redis, job ini SENGAJA TIDAK menulis apa pun ke database relasional
 * — hasilnya hanya didorong ke ring buffer di Cache (file/database driver)
 * lewat PingHistoryService.
 *
 * Catatan deployment: pastikan QUEUE_CONNECTION=sync di .env kalau hosting
 * tidak mengizinkan proses queue worker (`queue:work`) berjalan terus-menerus.
 * Dengan driver sync, Job::dispatch() akan dieksekusi langsung di request/
 * proses yang sama tanpa perlu worker terpisah — cocok untuk shared hosting.
 */
class CheckWebsitePingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 5;

    public function __construct(public Website $website, public int $timeoutSeconds = 2) {}

    public function handle(PingHistoryService $history): void
    {
        if (! $this->website->exists) {
            return;
        }

        if ($this->website->monitoring_status === 'paused') {
            return;
        }

        // Lock singkat agar tidak overlap kalau eksekusi sebelumnya masih
        // berjalan (mis. network lambat) saat "tick" berikutnya sudah lewat.
        $lock = Cache::lock('checking_website_ping_'.$this->website->id, 4);
        if (! $lock->get()) {
            return;
        }

        try {
            $start = microtime(true);
            $result = $this->executePing($this->website->url, $this->timeoutSeconds);
            $latencyMs = (int) round((microtime(true) - $start) * 1000);

            $history->record(
                website: $this->website,
                success: $result['success'],
                error: $result['error'],
                latencyMs: $latencyMs,
            );
        } finally {
            $lock->release();
        }
    }

    private function executePing(string $url, int $timeoutSeconds): array
    {
        if (app()->environment('testing')) {
            return ['success' => true, 'error' => null];
        }

        $host = parse_url($url, PHP_URL_HOST);
        if (! $host) {
            $host = preg_replace('#^https?://#i', '', $url);
            $host = explode('/', $host)[0];
            $host = explode(':', $host)[0];
        }

        if (empty($host)) {
            return ['success' => false, 'error' => 'Host tidak valid untuk ping'];
        }

        // Banyak shared hosting menonaktifkan fungsi exec()/shell_exec() demi
        // keamanan. Kalau exec() tidak tersedia, fallback ke pengecekan TCP
        // socket ke port 80/443 sebagai indikator host "hidup" (bukan ICMP
        // murni, tapi tetap berguna dan tidak butuh izin shell command).
        if (! function_exists('exec') || ! $this->isExecUsable()) {
            return $this->fallbackTcpCheck($host, $url, $timeoutSeconds);
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
            return ['success' => true, 'error' => null];
        }

        return [
            'success' => false,
            'error' => "Ping ke host '{$host}' gagal (Packet Loss / Unreachable)",
        ];
    }

    /**
     * Banyak provider shared hosting men-disable exec di php.ini
     * (disable_functions). Deteksi ini agar job tidak error, cukup fallback.
     */
    private function isExecUsable(): bool
    {
        $disabled = array_map('trim', explode(',', (string) ini_get('disable_functions')));

        return ! in_array('exec', $disabled, true);
    }

    /**
     * Fallback tanpa ICMP: coba buka koneksi TCP singkat ke port yang sesuai
     * skema URL-nya. Kalau berhasil connect, host dianggap "up".
     */
    private function fallbackTcpCheck(string $host, string $url, int $timeoutSeconds): array
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        $port = parse_url($url, PHP_URL_PORT) ?? (strtolower((string) $scheme) === 'https' ? 443 : 80);

        $connection = @fsockopen($host, (int) $port, $errno, $errstr, max(1, min($timeoutSeconds, 3)));

        if ($connection) {
            fclose($connection);

            return ['success' => true, 'error' => null];
        }

        return [
            'success' => false,
            'error' => "Tidak bisa membuka koneksi ke {$host}:{$port} ({$errstr})",
        ];
    }
}

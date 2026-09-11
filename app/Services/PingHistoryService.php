<?php

namespace App\Services;

use App\Models\Website;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Menyimpan riwayat ping (ICMP) sebagai ring buffer di Laravel Cache
 * (driver `file` atau `database` — cocok untuk shared hosting yang
 * tidak menyediakan Redis/Memcached). TIDAK PERNAH menulis ke tabel
 * database utama, sehingga aman dari bloating meski dijalankan tiap detik.
 *
 * Karena driver file/database bukan struktur list native (beda dengan Redis),
 * ring buffer di sini disimpan sebagai SATU array PHP per website di balik
 * satu cache key, dan setiap update dilakukan dengan pola read-modify-write
 * yang diamankan oleh Cache::lock() (atomic lock ini didukung baik oleh
 * driver `file` maupun `database` sejak Laravel 9, jadi tetap aman dari
 * race condition walau tanpa Redis).
 */
class PingHistoryService
{
    /** Jumlah maksimum entri yang disimpan (untuk 30 balok bar). */
    protected int $maxEntries = 30;

    /**
     * TTL cache key. Diberi jarak longgar dari maxEntries detik supaya
     * data tidak hilang kalau ada jeda singkat antar eksekusi cron.
     */
    protected int $ttlSeconds = 120;

    /** Berapa lama menunggu giliran lock sebelum menyerah (detik). */
    protected int $lockWaitSeconds = 3;

    protected function cacheKey(int $websiteId): string
    {
        return "ping_history_website_{$websiteId}";
    }

    protected function lockKey(int $websiteId): string
    {
        return "ping_history_lock_{$websiteId}";
    }

    /**
     * Catat satu hasil ping ke ring buffer. Dipanggil dari CheckWebsitePingJob.
     */
    public function record(Website $website, bool $success, ?string $error = null, ?int $latencyMs = null): void
    {
        $entry = [
            'success' => $success,
            'status' => $success ? 'online' : 'down',
            'latency_ms' => $latencyMs,
            'error' => $error,
            'checked_at' => Carbon::now()->toIso8601String(),
        ];

        $lock = Cache::lock($this->lockKey($website->id), 5);

        // block() otomatis mengambil lock, menjalankan callback, lalu melepas
        // lock -- kalau gagal dapat giliran dalam $lockWaitSeconds, ping ini
        // dilewati saja daripada membuat job menumpuk/menunggu lama.
        try {
            $lock->block($this->lockWaitSeconds, function () use ($website, $entry) {
                $key = $this->cacheKey($website->id);
                $history = Cache::get($key, []);

                $history[] = $entry;

                if (count($history) > $this->maxEntries) {
                    $history = array_slice($history, -$this->maxEntries);
                }

                Cache::put($key, $history, $this->ttlSeconds);
            });
        } catch (LockTimeoutException $e) {
            // Sengaja diabaikan: kalau lock sedang dipakai proses lain,
            // lebih baik lewati satu sample ping ini daripada job saling menumpuk.
        }
    }

    /**
     * Ambil riwayat ping (urutan kronologis: paling lama -> paling baru).
     *
     * @return array<int, array{success:bool,status:string,latency_ms:?int,error:?string,checked_at:string}>
     */
    public function get(int $websiteId): array
    {
        return Cache::get($this->cacheKey($websiteId), []);
    }

    /**
     * Hitung persentase uptime dari N ping terakhir yang tersimpan di cache.
     */
    public function uptimePercentage(int $websiteId): float
    {
        $history = $this->get($websiteId);
        $total = count($history);

        if ($total === 0) {
            return 100.0;
        }

        $up = collect($history)->filter(fn ($h) => (bool) $h['success'])->count();

        return round(($up / $total) * 100, 1);
    }

    /**
     * Hapus riwayat ping suatu website (misalnya saat website dihapus/di-reset).
     */
    public function flush(int $websiteId): void
    {
        Cache::forget($this->cacheKey($websiteId));
    }
}

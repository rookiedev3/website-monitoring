<?php

namespace App\Console\Commands;

use App\Jobs\CheckWebsitePingJob;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

/**
 * PINTU UTAMA untuk "ping tiap detik" di lingkungan SHARED HOSTING.
 *
 * Masalah: cron di shared hosting umumnya hanya bisa dipicu paling cepat
 * SEKALI PER MENIT (tidak ada `everySecond()` versi cron asli), dan
 * `php artisan schedule:work` (proses long-running) biasanya tidak
 * diizinkan berjalan terus-menerus di paket shared hosting.
 *
 * Solusi: cron tetap hanya dipicu SEKALI setiap menit, tapi command ini
 * sendiri yang melakukan loop internal selama ~55 detik, memanggil
 * pengecekan ping setiap ±1 detik lewat usleep(). Dengan begitu, dari sudut
 * pandang data yang masuk ke ring buffer cache, hasilnya tetap terasa
 * "real-time per detik" walau pemicunya cron per menit.
 *
 * Durasi sengaja dibuat < 60 detik (default 55) supaya proses ini selesai
 * SEBELUM cron menit berikutnya menembak lagi, plus Cache::lock sebagai
 * pengaman kedua kalau ternyata masih tumpang tindih (misal karena hosting
 * sedang lambat).
 */
class PingSweepCommand extends Command
{
    protected $signature = 'monitor:ping-sweep {--duration=55 : Berapa detik loop ini berjalan sebelum berhenti}';

    protected $description = 'Jalankan pengecekan ping berulang tiap ±1 detik selama N detik (workaround shared hosting)';

    public function handle(): int
    {
        // Jangan sampai dibatasi max_execution_time PHP CLI (biasanya sudah 0/unlimited,
        // tapi beberapa shared hosting tetap membatasi CLI juga).
        set_time_limit(0);

        $duration = max(1, (int) $this->option('duration'));

        $lock = Cache::lock('ping_sweep_running', $duration + 10);
        if (! $lock->get()) {
            $this->warn('Sweep ping sebelumnya sepertinya masih berjalan, dilewati agar tidak overlap.');

            return self::SUCCESS;
        }

        $this->info("Memulai ping sweep selama {$duration} detik...");

        try {
            $endAt = microtime(true) + $duration;

            while (microtime(true) < $endAt) {
                $tickStartedAt = microtime(true);

                $this->runOneTick();

                $elapsed = microtime(true) - $tickStartedAt;
                $sleepSeconds = 1 - $elapsed;

                if ($sleepSeconds > 0) {
                    usleep((int) round($sleepSeconds * 1_000_000));
                }
                // Kalau satu tick makan waktu > 1 detik (mis. banyak website /
                // fallback TCP lambat), langsung lanjut ke tick berikutnya
                // tanpa tidur tambahan -- lebih baik agak molor daripada
                // menumpuk antrian.
            }
        } finally {
            $lock->release();
        }

        $this->info('Ping sweep selesai.');

        return self::SUCCESS;
    }

    private function runOneTick(): void
    {
        Website::query()
            ->where('monitoring_status', '!=', 'paused')
            ->get(['id', 'url', 'monitoring_status'])
            ->each(fn (Website $website) => CheckWebsitePingJob::dispatch($website));
    }
}

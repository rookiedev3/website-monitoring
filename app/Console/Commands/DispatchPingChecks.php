<?php

namespace App\Console\Commands;

use App\Jobs\CheckWebsitePingJob;
use App\Models\Website;
use Illuminate\Console\Command;

/**
 * Satu "tick" pengecekan ping untuk semua website aktif.
 *
 * Dipakai oleh dua cara:
 * 1. Dipanggil berulang di dalam loop oleh PingSweepCommand (rekomendasi
 *    untuk shared hosting yang cron-nya hanya bisa jalan tiap 1 menit).
 * 2. Bisa juga didaftarkan langsung dengan ->everySecond() di routes/console.php
 *    KALAU hosting mendukung proses scheduler yang hidup terus-menerus
 *    (`php artisan schedule:work`). Sebagian besar shared hosting TIDAK
 *    mendukung ini, makanya opsi #1 yang dijadikan default di project ini.
 *
 * Dengan QUEUE_CONNECTION=sync di .env, dispatch() di bawah ini langsung
 * dieksekusi di proses yang sama tanpa perlu queue worker terpisah.
 */
class DispatchPingChecks extends Command
{
    protected $signature = 'monitor:dispatch-ping';

    protected $description = 'Dispatch CheckWebsitePingJob untuk semua website aktif (satu kali jalan / satu tick)';

    public function handle(): int
    {
        Website::query()
            ->where('monitoring_status', '!=', 'paused')
            ->get(['id', 'url', 'monitoring_status'])
            ->each(fn (Website $website) => CheckWebsitePingJob::dispatch($website));

        return self::SUCCESS;
    }
}

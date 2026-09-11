<?php

namespace App\Console\Commands;

use App\Jobs\CheckWebsiteHttpJob;
use App\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Dijalankan setiap menit oleh scheduler. Namun tiap website punya
 * kolom `check_interval` (dalam menit) sendiri-sendiri — job HTTP untuk
 * website tsb hanya benar-benar di-dispatch kalau intervalnya sudah lewat.
 * Timestamp "kapan terakhir di-dispatch" disimpan ringan di Cache, bukan DB,
 * supaya command ini tetap murah walau dipanggil tiap menit untuk banyak website.
 */
class DispatchHttpChecks extends Command
{
    protected $signature = 'monitor:dispatch-http';

    protected $description = 'Dispatch CheckWebsiteHttpJob untuk website yang check_interval-nya sudah tercapai';

    public function handle(): int
    {
        Website::query()
            ->where('monitoring_status', '!=', 'paused')
            ->get(['id', 'url', 'monitoring_status', 'check_interval', 'timeout_seconds'])
            ->each(function (Website $website) {
                $intervalMinutes = max(1, (int) ($website->check_interval ?? 1));
                $cacheKey = "last_http_dispatch:{$website->id}";
                $lastDispatchedAt = Cache::get($cacheKey);

                $isDue = ! $lastDispatchedAt
                    || Carbon::parse($lastDispatchedAt)->addMinutes($intervalMinutes)->lte(now());

                if ($isDue) {
                    CheckWebsiteHttpJob::dispatch($website);
                    Cache::put($cacheKey, now()->toIso8601String(), now()->addDay());
                }
            });

        return self::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\CheckWebsiteSslJob;
use App\Models\Website;
use Illuminate\Console\Command;

/**
 * Dijalankan sekali sehari (01:00) oleh scheduler.
 * Hanya website berskema https:// yang relevan untuk dicek sertifikatnya.
 */
class DispatchSslChecks extends Command
{
    protected $signature = 'monitor:dispatch-ssl';

    protected $description = 'Dispatch CheckWebsiteSslJob untuk semua website HTTPS aktif';

    public function handle(): int
    {
        Website::query()
            ->where('monitoring_status', '!=', 'paused')
            ->where('url', 'like', 'https://%')
            ->get(['id', 'url', 'monitoring_status'])
            ->each(fn (Website $website) => CheckWebsiteSslJob::dispatch($website));

        return self::SUCCESS;
    }
}

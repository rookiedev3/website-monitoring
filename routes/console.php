<?php

use App\Jobs\CheckWebsiteJob;
use App\Models\Website;

// Running setiap menit via Cron Job
Schedule::call(function () {
    $now = now();

    // Ambil website aktif beserta log terbarunya
    $websites = Website::where('monitoring_status', 'active')->with('latestLog')->get();

    foreach ($websites as $website) {
        $lastChecked = $website->latestLog?->checked_at;

        // Cek apakah selisih menit terakhir cek sudah >= check_interval milik website ini (atau belum pernah dicek)
        if (! $lastChecked || $lastChecked->diffInMinutes($now) >= $website->check_interval) {
            CheckWebsiteJob::dispatch($website);
        }
    }
})->everyMinute();

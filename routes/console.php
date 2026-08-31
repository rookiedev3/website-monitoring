<?php

use App\Jobs\CheckWebsiteJob;
use App\Models\Website;

// Running setiap menit via Cron Job
Schedule::call(function () {
    $now = now();

    // Ambil website aktif yang waktunya dicek berdasarkan check_interval masing-masing
    $websites = Website::where('monitoring_status', 'active')->get();

    foreach ($websites as $website) {
        $lastChecked = $website->updated_at; // atau kolom checked_at di log terakhir

        // Cek apakah selisih menit terakhir cek sudah >= check_interval milik website ini
        if (! $lastChecked || $lastChecked->diffInMinutes($now) >= $website->check_interval) {
            CheckWebsiteJob::dispatch($website);
        }
    }
})->everyMinute();

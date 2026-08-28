<?php

use App\Models\Website;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\CheckWebsiteJob;

Schedule::call(function () {
    // Menggunakan scope active() atau where('monitoring_status', 'active')
    Website::active()->chunk(100, function ($websites) {
        foreach ($websites as $website) {
            CheckWebsiteJob::dispatch($website);
        }
    });
})->everyMinute();
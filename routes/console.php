<?php

use App\Models\Website;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\CheckWebsiteJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Schedule::call(function () {
    // Ambil daftar website yang berstatus aktif dalam batch (chunk)
    Website::where('is_active', true)->chunk(100, function ($websites) {
        foreach ($websites as $website) {
            // Dispatch job pengecekan ke dalam Queue
            CheckWebsiteJob::dispatch($website);
        }
    });
})->everyMinute();
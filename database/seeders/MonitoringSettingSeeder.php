<?php

namespace Database\Seeders;

use App\Models\MonitoringSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonitoringSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MonitoringSetting::create([
            'default_interval_minutes' => 5,
            'timeout_seconds' => 10,
            'slow_threshold_ms' => 2000,
            'max_parallel_jobs' => 5,
            'ssl_warning_days' => 14,
        ]);
    }
}

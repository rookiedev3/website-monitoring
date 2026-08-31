<?php

namespace Tests\Feature;

use App\Jobs\CheckWebsiteJob;
use App\Models\MonitoringSetting;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckWebsiteJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_website_job_creates_monitoring_log_for_successful_response(): void
    {
        Http::fake([
            'https://example.com' => Http::response('OK', 200),
        ]);

        MonitoringSetting::create([
            'default_interval_minutes' => 5,
            'timeout_seconds' => 10,
            'slow_threshold_ms' => 2000,
            'max_parallel_jobs' => 5,
            'ssl_warning_days' => 14,
        ]);

        $website = Website::create([
            'customer_name' => 'Test Client',
            'website_name' => 'Example Website',
            'domain' => 'example.com',
            'url' => 'https://example.com',
            'category' => 'E-Commerce',
            'monitoring_status' => 'active',
            'check_interval' => 5,
            'timeout_seconds' => 10,
        ]);

        CheckWebsiteJob::dispatchSync($website);

        $this->assertDatabaseHas('monitoring_logs', [
            'website_id' => $website->id,
            'status' => 'online',
            'http_code' => 200,
        ]);
    }

    public function test_check_website_job_handles_connection_failure_and_creates_incident(): void
    {
        Http::fake([
            'https://down-site.test' => Http::response(null, 500),
        ]);

        $website = Website::create([
            'customer_name' => 'Down Client',
            'website_name' => 'Down Website',
            'domain' => 'down-site.test',
            'url' => 'https://down-site.test',
            'category' => 'Internal System',
            'monitoring_status' => 'active',
            'check_interval' => 5,
            'timeout_seconds' => 5,
        ]);

        CheckWebsiteJob::dispatchSync($website);

        $this->assertDatabaseHas('monitoring_logs', [
            'website_id' => $website->id,
            'status' => 'down',
            'http_code' => 500,
        ]);

        $this->assertDatabaseHas('incidents', [
            'website_id' => $website->id,
            'status' => 'open',
            'incident_type' => 'http_error',
        ]);
    }

    public function test_cached_monitoring_setting_does_not_throw_incomplete_object_exception(): void
    {
        Http::fake([
            'https://example.com' => Http::response('OK', 200),
        ]);

        MonitoringSetting::create([
            'slow_threshold_ms' => 1500,
            'ssl_warning_days' => 7,
            'timeout_seconds' => 5,
        ]);

        // Pre-warm cache
        Cache::remember('global_monitoring_settings', 3600, function () {
            $setting = MonitoringSetting::first();

            return $setting ? $setting->toArray() : null;
        });

        $website = Website::create([
            'customer_name' => 'Cache Test Client',
            'website_name' => 'Cache Website',
            'domain' => 'example.com',
            'url' => 'https://example.com',
            'category' => 'Company Profile',
            'monitoring_status' => 'active',
        ]);

        // Dispatch sync should not throw ErrorException (incomplete object)
        CheckWebsiteJob::dispatchSync($website);

        $this->assertDatabaseCount('monitoring_logs', 1);
    }
}

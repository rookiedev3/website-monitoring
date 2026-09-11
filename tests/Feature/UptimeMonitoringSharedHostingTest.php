<?php

namespace Tests\Feature;

use App\Jobs\CheckWebsiteHttpJob;
use App\Jobs\CheckWebsitePingJob;
use App\Jobs\CheckWebsiteSslJob;
use App\Models\MonitoringLog;
use App\Models\MonitoringSetting;
use App\Models\Website;
use App\Services\PingHistoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UptimeMonitoringSharedHostingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        MonitoringSetting::create([
            'slow_threshold_ms' => 2000,
            'ssl_warning_days' => 14,
            'timeout_seconds' => 5,
        ]);
    }

    public function test_ping_history_service_ring_buffer_and_uptime(): void
    {
        $website = Website::create([
            'customer_name' => 'Acme Corp',
            'website_name' => 'Acme Web',
            'domain' => 'acme.test',
            'url' => 'https://acme.test',
            'monitoring_status' => 'active',
        ]);

        $service = app(PingHistoryService::class);

        // Record 35 items; only 30 should remain in the ring buffer
        for ($i = 1; $i <= 35; $i++) {
            $isSuccess = ($i % 5 !== 0); // 80% success rate
            $service->record($website, $isSuccess, $isSuccess ? null : 'Packet loss', 25);
        }

        $history = $service->get($website->id);
        $this->assertCount(30, $history);

        // Last item was 35 (which is divisible by 5, so success: false)
        $lastItem = end($history);
        $this->assertFalse($lastItem['success']);
        $this->assertEquals('Packet loss', $lastItem['error']);

        $uptime = $service->uptimePercentage($website->id);
        $this->assertIsFloat($uptime);
        $this->assertGreaterThanOrEqual(0.0, $uptime);
        $this->assertLessThanOrEqual(100.0, $uptime);
    }

    public function test_check_website_http_job_creates_log_and_respects_paused_status(): void
    {
        Http::fake([
            'https://example.com' => Http::response('OK', 200),
        ]);

        $activeWeb = Website::create([
            'customer_name' => 'Active Client',
            'website_name' => 'Active Site',
            'domain' => 'example.com',
            'url' => 'https://example.com',
            'monitoring_status' => 'active',
        ]);

        $pausedWeb = Website::create([
            'customer_name' => 'Paused Client',
            'website_name' => 'Paused Site',
            'domain' => 'paused.com',
            'url' => 'https://paused.com',
            'monitoring_status' => 'paused',
        ]);

        // Run active web
        CheckWebsiteHttpJob::dispatchSync($activeWeb);
        $this->assertDatabaseHas('monitoring_logs', [
            'website_id' => $activeWeb->id,
            'status' => 'online',
            'http_code' => 200,
        ]);

        // Run paused web; should not write logs
        CheckWebsiteHttpJob::dispatchSync($pausedWeb);
        $this->assertDatabaseMissing('monitoring_logs', [
            'website_id' => $pausedWeb->id,
        ]);
    }

    public function test_check_website_ping_job_does_not_bloat_database(): void
    {
        $website = Website::create([
            'customer_name' => 'Ping Client',
            'website_name' => 'Ping Site',
            'domain' => 'example.com',
            'url' => 'https://example.com',
            'monitoring_status' => 'active',
        ]);

        $initialLogCount = MonitoringLog::count();

        // Run Ping Job multiple times
        for ($i = 0; $i < 5; $i++) {
            CheckWebsitePingJob::dispatchSync($website);
        }

        // Must NOT write to monitoring_logs table
        $this->assertEquals($initialLogCount, MonitoringLog::count());

        // BUT data must be in PingHistoryService (Cache)
        $service = app(PingHistoryService::class);
        $history = $service->get($website->id);
        $this->assertCount(5, $history);
    }

    public function test_check_website_ping_job_respects_paused_status(): void
    {
        $pausedWeb = Website::create([
            'customer_name' => 'Paused Client',
            'website_name' => 'Paused Site',
            'domain' => 'paused.com',
            'url' => 'https://paused.com',
            'monitoring_status' => 'paused',
        ]);

        CheckWebsitePingJob::dispatchSync($pausedWeb);

        $service = app(PingHistoryService::class);
        $history = $service->get($pausedWeb->id);
        $this->assertEmpty($history);
    }

    public function test_check_website_ssl_job_respects_paused_status(): void
    {
        $pausedWeb = Website::create([
            'customer_name' => 'Paused Client',
            'website_name' => 'Paused Site',
            'domain' => 'paused.com',
            'url' => 'https://paused.com',
            'monitoring_status' => 'paused',
        ]);

        CheckWebsiteSslJob::dispatchSync($pausedWeb);

        $this->assertDatabaseMissing('monitoring_logs', [
            'website_id' => $pausedWeb->id,
        ]);
    }

    public function test_artisan_commands_run_successfully(): void
    {
        Http::fake([
            'https://test.com' => Http::response('OK', 200),
        ]);

        $website = Website::create([
            'customer_name' => 'Artisan Client',
            'website_name' => 'Artisan Site',
            'domain' => 'test.com',
            'url' => 'https://test.com',
            'check_interval' => 1,
            'monitoring_status' => 'active',
        ]);

        $this->artisan('monitor:dispatch-http')->assertSuccessful();
        $this->artisan('monitor:dispatch-ping')->assertSuccessful();
        $this->artisan('monitor:dispatch-ssl')->assertSuccessful();
    }
}

<?php

namespace App\Jobs;

use App\Models\MonitoringLog;
use App\Models\MonitoringSetting;
use App\Models\Website;
use App\Services\IncidentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CheckWebsiteHttpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;

    public function __construct(public Website $website) {}

    public function handle(): void
    {
        if (! $this->website->exists) {
            return;
        }

        if ($this->website->monitoring_status === 'paused') {
            return;
        }

        $lock = Cache::lock('checking_website_http_'.$this->website->id, 25);
        if (! $lock->get()) {
            return;
        }

        try {
            $settings = Cache::remember('global_monitoring_settings', 3600, function () {
                return MonitoringSetting::first()?->only([
                    'slow_threshold_ms',
                    'timeout_seconds',
                ]);
            });

            $slowThreshold = $settings['slow_threshold_ms'] ?? 2000;
            $timeoutSeconds = $this->website->timeout_seconds ?? ($settings['timeout_seconds'] ?? 10);

            $startTime = microtime(true);
            $url = $this->website->url;

            $status = 'online';
            $incidentType = null;
            $httpCode = null;
            $errorType = null;
            $errorMessage = null;
            $responseTimeMs = null;

            try {
                $response = Http::timeout($timeoutSeconds)
                    ->withOptions(['verify' => false])
                    ->get($url);

                $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
                $httpCode = $response->status();

                if ($response->successful()) {
                    if ($responseTimeMs > $slowThreshold) {
                        $status = 'warning';
                        $incidentType = 'slow';
                    }
                } else {
                    $status = 'down';
                    $incidentType = 'http_error';
                    $errorType = 'HTTP_SERVER_ERROR';
                    $errorMessage = "Server merespons dengan HTTP status: {$httpCode}";
                }
            } catch (ConnectionException $e) {
                $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
                $status = 'down';

                if (str_contains(strtolower($e->getMessage()), 'timed out')) {
                    $incidentType = 'timeout';
                    $errorType = 'CONNECTION_TIMEOUT';
                } else {
                    $incidentType = 'down';
                    $errorType = 'CONNECTION_FAILED';
                }
                $errorMessage = $e->getMessage();
            } catch (\Throwable $e) {
                $responseTimeMs = (int) round((microtime(true) - $startTime) * 1000);
                $status = 'down';
                $incidentType = 'down';
                $errorType = 'UNKNOWN_ERROR';
                $errorMessage = $e->getMessage();
            }

            // Sertakan info SSL terakhir dari cache agar log HTTP tidak menimpa status SSL menjadi null
            $cachedSsl = Cache::get("website_ssl_info_{$this->website->id}", []);

            // Simpan log khusus HTTP
            MonitoringLog::create([
                'website_id' => $this->website->id,
                'status' => $status,
                'http_code' => $httpCode,
                'response_time_ms' => $responseTimeMs,
                'ssl_valid' => $cachedSsl['ssl_valid'] ?? null,
                'ssl_expired_at' => $cachedSsl['ssl_expired_at'] ?? null,
                'ssl_days_left' => $cachedSsl['ssl_days_left'] ?? null,
                'error_type' => $errorType,
                'error_message' => $errorMessage,
                'checked_at' => Carbon::now(),
            ]);

            app(IncidentService::class)->evaluate($this->website, $status, $incidentType);

        } finally {
            $lock->release();
        }
    }
}

<?php

namespace App\Services;

use App\Models\Incident;
use App\Models\Website;

class IncidentService
{
    public function evaluate(Website $website, string $currentStatus, ?string $incidentType = null): void
    {
        $openIncident = Incident::where('website_id', $website->id)
            ->whereIn('status', ['open', 'on_progress'])
            ->latest('started_at')
            ->first();

        if ($currentStatus !== 'online') {
            if (! $openIncident) {
                Incident::create([
                    'website_id'    => $website->id,
                    'incident_type' => $incidentType ?? $this->mapIncidentType($currentStatus),
                    'status'        => 'open',
                    'started_at'    => now(),
                ]);
            }
            return;
        }

        if ($openIncident) {
            $openIncident->update([
                'resolved_at'      => now(),
                'duration_seconds' => abs(now()->diffInSeconds($openIncident->started_at)),
                'status'           => 'solved',
            ]);
        }
    }

    private function mapIncidentType(string $status): string
    {
        return match ($status) {
            'down'      => 'down',
            'warning'   => 'slow',
            'ssl_error' => 'ssl',
            default     => 'http_error',
        };
    }
}
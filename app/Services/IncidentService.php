<?php

namespace App\Services;

use App\Models\Incident;
use App\Models\User;
use App\Models\Website;
// 1. IMPORT CLASS NOTIFIKASI & FACADE NOTIFICATION
use App\Notifications\WebsiteDownNotification;
use App\Notifications\WebsiteUpNotification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class IncidentService
{
    public function evaluate(Website $website, string $currentStatus, ?string $incidentType = null): void
    {
        // 1. Ambil penerima notifikasi (Super Admin & Programmer yang aktif)
        $recipients = User::notificationRecipients()->get();

        $logCount = $website->monitoringLogs()->count();

        // --- SKENARIO 1: WEBSITE DOWN ---
        if ($currentStatus === 'down') {
            // Cari insiden DOWN yang sedang aktif (open / on_progress)
            $openDownIncident = Incident::where('website_id', $website->id)
                ->whereIn('status', ['open', 'on_progress'])
                ->whereIn('incident_type', ['down', 'timeout', 'http_error'])
                ->latest('started_at')
                ->first();

            if (! $openDownIncident) {
                // Tutup insiden non-down yang mungkin masih terbuka (misal: ssl/slow) agar tidak memblokir insiden DOWN
                Incident::where('website_id', $website->id)
                    ->whereIn('status', ['open', 'on_progress'])
                    ->update([
                        'status' => 'solved',
                        'resolved_at' => now(),
                        'resolution' => 'Insiden ditutup otomatis karena status website berubah menjadi DOWN.',
                    ]);

                $startTime = now();
                $type = $incidentType ?? 'down';

                // A. Buat Incident DOWN Baru
                $incident = Incident::create([
                    'website_id' => $website->id,
                    'incident_type' => $type,
                    'status' => 'open',
                    'started_at' => $startTime,
                ]);

                // B. KIRIM NOTIFIKASI WEBSITE DOWN
                Notification::send(
                    $recipients,
                    new WebsiteDownNotification(
                        $website,
                        $incident,
                        $type,
                        $startTime->format('d M Y - H:i:s')
                    )
                );
            }

            return;
        }

        // --- SKENARIO 2: SSL ERROR / WARNING (SLOW) ---
        if (in_array($currentStatus, ['ssl_error', 'warning'])) {
            // Jika data web masih baru (<= 1 log) atau hanya SSL check,
            // JANGAN kirim notifikasi WebsiteDownNotification.
            $openIncident = Incident::where('website_id', $website->id)
                ->whereIn('status', ['open', 'on_progress'])
                ->first();

            if (! $openIncident && $logCount > 1) {
                $startTime = now();
                $type = $incidentType ?? ($currentStatus === 'ssl_error' ? 'ssl' : 'slow');

                Incident::create([
                    'website_id' => $website->id,
                    'incident_type' => $type,
                    'status' => 'open',
                    'started_at' => $startTime,
                ]);
            }

            return;
        }

        // --- SKENARIO 3: WEBSITE RECOVERY (ONLINE) ---
        if ($currentStatus === 'online') {
            $openIncidents = Incident::where('website_id', $website->id)
                ->whereIn('status', ['open', 'on_progress'])
                ->get();

            foreach ($openIncidents as $openIncident) {
                $resolvedAt = now();
                $isDownIncident = in_array($openIncident->incident_type, ['down', 'timeout', 'http_error']);

                $durationFormatted = $openIncident->started_at->diffForHumans($resolvedAt, [
                    'syntax' => Carbon::DIFF_ABSOLUTE,
                    'parts' => 3,
                ]);

                // Update Status Incident Menjadi Solved
                $openIncident->update([
                    'resolved_at' => $resolvedAt,
                    'duration_seconds' => abs($resolvedAt->diffInSeconds($openIncident->started_at)),
                    'status' => 'solved',
                ]);

                // Kirim notifikasi recovery jika insiden yang diselesaikan adalah insiden DOWN
                if ($isDownIncident) {
                    Notification::send(
                        $recipients,
                        new WebsiteUpNotification(
                            $website,
                            $openIncident,
                            $durationFormatted
                        )
                    );
                }
            }
        }
    }

    private function mapIncidentType(string $status): string
    {
        return match ($status) {
            'down' => 'down',
            'warning' => 'slow',
            'ssl_error' => 'ssl',
            default => 'http_error',
        };
    }
}

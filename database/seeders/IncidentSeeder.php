<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\User;
use App\Models\Website;
use App\Notifications\WebsiteDownNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Notification;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipients = User::whereIn('role', ['super_admin', 'programmer'])
            ->where('is_active', true)
            ->get();

        $websites = Website::all();

        foreach ($websites as $website) {
            // Skip jika sudah ada insiden aktif untuk website ini
            $existingActive = Incident::where('website_id', $website->id)
                ->whereIn('status', ['open', 'on_progress'])
                ->exists();

            if ($existingActive) {
                continue;
            }

            // Tentukan tipe dan status insiden
            $status = fake()->randomElement(['open', 'on_progress', 'solved']);
            $type = fake()->randomElement(['down', 'timeout', 'http_error', 'ssl', 'slow']);
            $startTime = now()->subMinutes(fake()->numberBetween(10, 1440));

            $incidentData = [
                'website_id' => $website->id,
                'assigned_to' => User::whereIn('role', ['super_admin', 'programmer'])->inRandomOrder()->first()?->id,
                'incident_type' => $type,
                'status' => $status,
                'started_at' => $startTime,
            ];

            if ($status === 'solved') {
                $resolvedAt = (clone $startTime)->addMinutes(fake()->numberBetween(5, 120));
                $incidentData['resolved_at'] = $resolvedAt;
                $incidentData['duration_seconds'] = abs($resolvedAt->diffInSeconds($startTime));
                $incidentData['root_cause'] = 'Masalah server / jaringan telah diselesaikan.';
                $incidentData['resolution'] = 'Restart service cURL dan optimasi koneksi.';
            }

            $incident = Incident::create($incidentData);

            // Jika insiden yang dibuat adalah insiden DOWN yang aktif (open / on_progress), kirim notifikasi
            if (in_array($status, ['open', 'on_progress']) && in_array($type, ['down', 'timeout', 'http_error'])) {
                if ($recipients->isNotEmpty()) {
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
            }
        }
    }
}

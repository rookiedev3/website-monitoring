<?php

namespace Tests\Feature;

use App\Models\Incident;
use App\Models\User;
use App\Models\Website;
use App\Notifications\WebsiteDownNotification;
use App\Notifications\WebsiteUpNotification;
use App\Services\IncidentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_website_down_notification_is_sent_to_super_admin_and_programmer(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $programmer = User::factory()->create([
            'role' => 'programmer',
            'is_active' => true,
        ]);

        $viewer = User::factory()->create([
            'role' => 'viewer',
            'is_active' => true,
        ]);

        $website = Website::create([
            'customer_name' => 'Client A',
            'website_name' => 'Web Down Test',
            'url' => 'https://down-example.com',
            'domain' => 'down-example.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $service = new IncidentService;
        $service->evaluate($website, 'down', 'down');

        // Notification must be sent to super_admin and programmer
        Notification::assertSentTo(
            [$superAdmin, $programmer],
            WebsiteDownNotification::class
        );

        // Notification must NOT be sent to viewer
        Notification::assertNotSentTo(
            [$viewer],
            WebsiteDownNotification::class
        );

        $this->assertDatabaseHas('incidents', [
            'website_id' => $website->id,
            'status' => 'open',
            'incident_type' => 'down',
        ]);
    }

    public function test_website_up_notification_is_sent_when_incident_is_resolved(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $programmer = User::factory()->create([
            'role' => 'programmer',
            'is_active' => true,
        ]);

        $website = Website::create([
            'customer_name' => 'Client B',
            'website_name' => 'Web Recovery Test',
            'url' => 'https://recovery-example.com',
            'domain' => 'recovery-example.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $incident = Incident::create([
            'website_id' => $website->id,
            'incident_type' => 'down',
            'status' => 'open',
            'started_at' => now()->subMinutes(15),
        ]);

        $service = new IncidentService;
        $service->evaluate($website, 'online');

        Notification::assertSentTo(
            [$superAdmin, $programmer],
            WebsiteUpNotification::class
        );

        $this->assertDatabaseHas('incidents', [
            'id' => $incident->id,
            'status' => 'solved',
        ]);
    }

    public function test_user_can_mark_notification_as_read_and_redirect(): void
    {
        $programmer = User::factory()->create([
            'role' => 'programmer',
            'is_active' => true,
        ]);

        $website = Website::create([
            'customer_name' => 'Client C',
            'website_name' => 'Read Notif Test',
            'url' => 'https://readnotif-example.com',
            'domain' => 'readnotif-example.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $incident = Incident::create([
            'website_id' => $website->id,
            'incident_type' => 'down',
            'status' => 'open',
            'started_at' => now(),
        ]);

        $programmer->notify(new WebsiteDownNotification(
            $website,
            $incident,
            'down',
            now()->format('d M Y - H:i:s')
        ));

        $notification = $programmer->unreadNotifications->first();
        $this->assertNotNull($notification);

        $response = $this->actingAs($programmer)
            ->get(route('notifications.readAndRedirect', [
                $notification->id,
                'redirect' => route('incidents.show', $incident->id),
            ]));

        $response->assertRedirect(route('incidents.show', $incident->id));
        $this->assertEquals(0, $programmer->fresh()->unreadNotifications->count());
    }

    public function test_user_can_mark_all_notifications_as_read(): void
    {
        $programmer = User::factory()->create([
            'role' => 'programmer',
            'is_active' => true,
        ]);

        $website = Website::create([
            'customer_name' => 'Client D',
            'website_name' => 'Mark All Test',
            'url' => 'https://markall-example.com',
            'domain' => 'markall-example.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $incident = Incident::create([
            'website_id' => $website->id,
            'incident_type' => 'down',
            'status' => 'open',
            'started_at' => now(),
        ]);

        $programmer->notify(new WebsiteDownNotification(
            $website,
            $incident,
            'down',
            now()->format('d M Y - H:i:s')
        ));

        $this->assertEquals(1, $programmer->unreadNotifications->count());

        $response = $this->actingAs($programmer)
            ->post(route('notifications.markAllRead'));

        $response->assertSessionHas('success');
        $this->assertEquals(0, $programmer->fresh()->unreadNotifications->count());
    }

    public function test_ssl_error_or_initial_empty_data_does_not_send_down_notification(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $website = Website::create([
            'customer_name' => 'Client E',
            'website_name' => 'SSL Empty Data Test',
            'url' => 'https://ssl-empty-example.com',
            'domain' => 'ssl-empty-example.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $service = new IncidentService;
        $service->evaluate($website, 'ssl_error', 'ssl');

        // Notification must NOT be sent for SSL error / initial check
        Notification::assertNothingSent();
    }

    public function test_programmer_clicking_notification_for_unassigned_incident_does_not_error(): void
    {
        $programmer = User::factory()->create([
            'role' => 'programmer',
            'is_active' => true,
        ]);

        $website = Website::create([
            'customer_name' => 'Client F',
            'website_name' => 'Incident View Test',
            'url' => 'https://incview-example.com',
            'domain' => 'incview-example.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $incident = Incident::create([
            'website_id' => $website->id,
            'incident_type' => 'down',
            'status' => 'on_progress',
            'assigned_to' => null,
            'started_at' => now(),
        ]);

        $programmer->notify(new WebsiteDownNotification(
            $website,
            $incident,
            'down',
            now()->format('d M Y - H:i:s')
        ));

        $notification = $programmer->unreadNotifications->first();

        $response = $this->actingAs($programmer)
            ->get(route('notifications.readAndRedirect', [$notification->id]));

        $response->assertRedirect(route('incidents.show', $incident->id));

        $viewResponse = $this->actingAs($programmer)
            ->get(route('incidents.show', $incident->id));

        $viewResponse->assertStatus(200);
        $viewResponse->assertSeeText('Detail & Penanganan Incident');
    }

    public function test_notification_recipients_scope_returns_active_super_admin_and_programmer(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin', 'is_active' => true]);
        $programmer = User::factory()->create(['role' => 'programmer', 'is_active' => true]);
        $inactiveAdmin = User::factory()->create(['role' => 'super_admin', 'is_active' => false]);
        $viewer = User::factory()->create(['role' => 'viewer', 'is_active' => true]);

        $recipients = User::notificationRecipients()->get();

        $this->assertTrue($recipients->contains($superAdmin));
        $this->assertTrue($recipients->contains($programmer));
        $this->assertFalse($recipients->contains($inactiveAdmin));
        $this->assertFalse($recipients->contains($viewer));
    }

    public function test_programmer_resolving_incident_sends_notification_to_super_admin_and_programmer(): void
    {
        Notification::fake();

        $superAdmin = User::factory()->create(['role' => 'super_admin', 'is_active' => true]);
        $programmer = User::factory()->create(['role' => 'programmer', 'is_active' => true]);
        $otherProgrammer = User::factory()->create(['role' => 'programmer', 'is_active' => true]);
        $viewer = User::factory()->create(['role' => 'viewer', 'is_active' => true]);

        $website = Website::create([
            'customer_name' => 'Client G',
            'website_name' => 'Resolve Test',
            'url' => 'https://resolve-example.com',
            'domain' => 'resolve-example.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $incident = Incident::create([
            'website_id' => $website->id,
            'incident_type' => 'down',
            'status' => 'on_progress',
            'assigned_to' => $programmer->id,
            'started_at' => now()->subHour(),
        ]);

        $response = $this->actingAs($programmer)
            ->put(route('incidents.update', $incident->id), [
                'root_cause' => 'Server restarted',
                'resolution' => 'Service brought back online',
            ]);

        $response->assertSessionHas('success');

        Notification::assertSentTo(
            [$superAdmin, $programmer, $otherProgrammer],
            WebsiteUpNotification::class
        );

        Notification::assertNotSentTo(
            [$viewer],
            WebsiteUpNotification::class
        );
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_edit_website_page(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $website = Website::create([
            'customer_name' => 'PT Testing',
            'website_name' => 'Test Site',
            'url' => 'https://test-edit-site.com',
            'domain' => 'test-edit-site.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $response = $this->actingAs($superAdmin)
            ->get(route('websites.edit', $website->id));

        $response->assertStatus(200);
        $response->assertSee('PT Testing');
        $response->assertSee('Test Site');
    }

    public function test_super_admin_can_update_website(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $website = Website::create([
            'customer_name' => 'PT Lama',
            'website_name' => 'Old Project',
            'url' => 'https://old-project.com',
            'domain' => 'old-project.com',
            'check_interval' => 5,
            'timeout_seconds' => 10,
            'monitoring_status' => 'active',
        ]);

        $response = $this->actingAs($superAdmin)
            ->put(route('websites.update', $website->id), [
                'customer_name' => 'PT Baru Sukses',
                'website_name' => 'New Project Name',
                'url' => 'https://new-project.com',
                'category' => 'webapp',
                'check_interval' => 10,
                'timeout_seconds' => 15,
                'monitoring_status' => 'paused',
                'notes' => 'Updated via form',
            ]);

        $response->assertRedirect(route('websites.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('websites', [
            'id' => $website->id,
            'customer_name' => 'PT Baru Sukses',
            'website_name' => 'New Project Name',
            'url' => 'https://new-project.com',
            'domain' => 'new-project.com',
            'check_interval' => 10,
            'timeout_seconds' => 15,
            'monitoring_status' => 'paused',
        ]);
    }
}

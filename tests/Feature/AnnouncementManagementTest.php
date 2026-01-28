<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_announcements_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.announcements.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_announcement()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.announcements.store'), [
            'title' => 'Important Update',
            'content' => 'We are launching a new feature.',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.announcements.index'));
        $this->assertDatabaseHas('announcements', [
            'title' => 'Important Update',
            'is_published' => true,
        ]);
    }

    public function test_investor_can_view_published_announcements()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        Announcement::create([
            'title' => 'Public News',
            'content' => 'Everyone can see this.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->actingAs($investor)->get(route('investor.announcements.index'));

        $response->assertStatus(200);
        $response->assertSee('Public News');
    }

    public function test_investor_cannot_see_draft_announcements()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        Announcement::create([
            'title' => 'Draft News',
            'content' => 'Not ready yet.',
            'is_published' => false,
        ]);

        $response = $this->actingAs($investor)->get(route('investor.announcements.index'));

        $response->assertStatus(200);
        $response->assertDontSee('Draft News');
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertStatus(200);
    }

    public function test_investor_cannot_access_admin_dashboard()
    {
        $investor = User::factory()->create(['role' => 'investor']);

        $response = $this->actingAs($investor)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_investor_can_access_investor_dashboard()
    {
        $investor = User::factory()->create(['role' => 'investor']);

        $response = $this->actingAs($investor)->get('/investor/dashboard');

        $response->assertStatus(200);
    }

    public function test_admin_cannot_access_investor_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/investor/dashboard');

        $response->assertStatus(403);
    }

    public function test_dashboard_redirects_admin_to_admin_dashboard()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertRedirect('/admin/dashboard');
    }

    public function test_dashboard_redirects_investor_to_investor_dashboard()
    {
        $investor = User::factory()->create(['role' => 'investor']);

        $response = $this->actingAs($investor)->get('/dashboard');

        $response->assertRedirect('/investor/dashboard');
    }
}

<?php

namespace Tests\Feature;

use App\Models\Offering;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllocationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_allocations_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.allocations.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.allocations.index');
    }

    public function test_admin_can_create_allocation()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $investor = User::factory()->create(['role' => 'investor']);
        $offering = Offering::create([
            'name' => 'Test Offering',
            'type' => 'Land Banking',
            'price' => 100000,
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.allocations.store'), [
            'user_id' => $investor->id,
            'offering_id' => $offering->id,
            'amount' => 500000,
            'units' => 5,
            'allocation_date' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('admin.allocations.index'));
        $this->assertDatabaseHas('allocations', [
            'user_id' => $investor->id,
            'offering_id' => $offering->id,
            'amount' => 500000,
            'units' => 5,
        ]);
    }

    public function test_investor_cannot_manage_allocations()
    {
        $investor = User::factory()->create(['role' => 'investor']);

        $response = $this->actingAs($investor)->get(route('admin.allocations.index'));

        $response->assertStatus(403); // Or 404/redirect depending on middleware behavior, usually 403 for role middleware
    }
}

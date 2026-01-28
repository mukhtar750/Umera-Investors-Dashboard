<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_create_offering_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.offerings.create'));

        $response->assertStatus(200);
        $response->assertSee('Create New Offering');
    }

    public function test_admin_can_create_offering()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $offeringData = [
            'name' => 'New Tech Fund',
            'type' => 'fund',
            'description' => 'Investing in AI startups.',
            'price' => 100000,
            'min_investment' => 10000,
            'total_units' => 10,
            'location' => 'Lagos',
            'status' => 'coming_soon',
        ];

        $response = $this->actingAs($admin)->post(route('admin.offerings.store'), $offeringData);

        $response->assertRedirect(route('admin.offerings.index'));
        $response->assertSessionHas('success', 'Offering created successfully!');

        $this->assertDatabaseHas('offerings', [
            'name' => 'New Tech Fund',
            'price' => 100000,
        ]);
    }

    public function test_investor_cannot_create_offering()
    {
        $investor = User::factory()->create(['role' => 'investor']);

        $offeringData = [
            'name' => 'Illegal Fund',
            'description' => 'This should fail.',
            'target_amount' => 1000000,
            'min_investment' => 10000,
            'status' => 'open',
        ];

        $response = $this->actingAs($investor)->post(route('admin.offerings.store'), $offeringData);

        $response->assertStatus(403);
    }
}

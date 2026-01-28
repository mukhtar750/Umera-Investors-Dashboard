<?php

namespace Tests\Feature;

use App\Models\Allocation;
use App\Models\Offering;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_transactions()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.transactions.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.transactions.index');
    }

    public function test_admin_can_record_transaction()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $investor = User::factory()->create(['role' => 'investor']);

        $response = $this->actingAs($admin)->post(route('admin.transactions.store'), [
            'user_id' => $investor->id,
            'amount' => 50000,
            'type' => 'deposit',
            'status' => 'completed',
            'reference' => 'REF123',
            'description' => 'Initial deposit',
        ]);

        $response->assertRedirect(route('admin.transactions.index'));
        $this->assertDatabaseHas('transactions', [
            'user_id' => $investor->id,
            'amount' => 50000,
            'type' => 'deposit',
            'status' => 'completed',
        ]);
    }

    public function test_investor_can_view_own_transactions()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        $offering = Offering::create([
            'name' => 'Test Offering',
            'type' => 'real_estate',
            'price' => 10000,
            'min_investment' => 10000,
            'roi_percentage' => 0.15,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'open',
            'available_units' => 10,
            'location' => 'Lagos',
            'description' => 'Test',
        ]);

        $allocation = Allocation::create([
            'user_id' => $investor->id,
            'offering_id' => $offering->id,
            'units' => 1,
            'amount' => 10000,
            'status' => 'active',
            'allocation_date' => now(),
        ]);

        Transaction::create([
            'user_id' => $investor->id,
            'allocation_id' => $allocation->id,
            'amount' => 10000,
            'type' => 'payout',
            'status' => 'completed',
            'reference' => 'PAY123',
            'description' => 'Payout',
        ]);

        $response = $this->actingAs($investor)->get(route('investor.transactions.index'));

        $response->assertStatus(200);
        $response->assertSee('PAY123');
    }

    public function test_investor_cannot_see_other_transactions()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        $otherInvestor = User::factory()->create(['role' => 'investor']);

        $offering = Offering::create([
            'name' => 'Other Offering',
            'type' => 'real_estate',
            'price' => 20000,
            'min_investment' => 20000,
            'roi_percentage' => 0.1,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'open',
            'available_units' => 10,
            'location' => 'Abuja',
            'description' => 'Other',
        ]);

        $allocation = Allocation::create([
            'user_id' => $otherInvestor->id,
            'offering_id' => $offering->id,
            'units' => 1,
            'amount' => 20000,
            'status' => 'active',
            'allocation_date' => now(),
        ]);

        Transaction::create([
            'user_id' => $otherInvestor->id,
            'allocation_id' => $allocation->id,
            'amount' => 20000,
            'type' => 'payout',
            'status' => 'completed',
            'reference' => 'OTHERPAY',
            'description' => 'Payout',
        ]);

        $response = $this->actingAs($investor)->get(route('investor.transactions.index'));

        $response->assertDontSee('OTHERPAY');
    }
}

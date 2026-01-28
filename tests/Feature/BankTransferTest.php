<?php

namespace Tests\Feature;

use App\Models\Allocation;
use App\Models\Offering;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BankTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_investor_can_invest_via_bank_transfer()
    {
        Storage::fake('public');

        $investor = User::factory()->create(['role' => 'investor', 'wallet_balance' => 0]);
        $offering = Offering::create([
            'name' => 'Test Offering',
            'type' => 'real_estate',
            'price' => 10000,
            'min_investment' => 10000,
            'roi_percentage' => 0.15,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'open',
            'available_units' => 100,
            'location' => 'Lagos',
            'description' => 'Test Description',
        ]);

        $file = UploadedFile::fake()->image('receipt.jpg');

        $response = $this->actingAs($investor)->post(route('investor.offerings.invest', $offering), [
            'units' => 2,
            'payment_method' => 'bank_transfer',
            'proof_of_payment' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Assert Transaction Created
        $this->assertDatabaseHas('transactions', [
            'user_id' => $investor->id,
            'amount' => 20000,
            'type' => 'investment_payment',
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
        ]);

        $transaction = Transaction::where('user_id', $investor->id)->first();
        $this->assertNotNull($transaction->proof_of_payment);
        $this->assertNotNull($transaction->allocation_id);
        Storage::disk('public')->assertExists($transaction->proof_of_payment);

        // Assert Allocation Created
        $this->assertDatabaseHas('allocations', [
            'user_id' => $investor->id,
            'offering_id' => $offering->id,
            'units' => 2,
            'amount' => 20000,
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_approve_bank_transfer()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        $admin = User::factory()->create(['role' => 'admin']);

        $offering = Offering::create([
            'name' => 'Test Offering',
            'type' => 'real_estate',
            'price' => 10000,
            'min_investment' => 10000,
            'roi_percentage' => 0.15,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'open',
            'available_units' => 100,
            'location' => 'Lagos',
            'description' => 'Test Description',
        ]);

        // Create pending allocation and transaction
        $allocation = Allocation::create([
            'user_id' => $investor->id,
            'offering_id' => $offering->id,
            'units' => 1,
            'amount' => 10000,
            'status' => 'pending',
            'allocation_date' => now(),
        ]);

        $transaction = Transaction::create([
            'user_id' => $investor->id,
            'allocation_id' => $allocation->id,
            'amount' => 10000,
            'type' => 'investment_payment',
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'proof_of_payment' => 'proofs/test.jpg',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.transactions.approve', $transaction));

        $response->assertRedirect();

        // Refresh models
        $transaction->refresh();
        $allocation->refresh();

        $this->assertEquals('completed', $transaction->status);
        $this->assertEquals('active', $allocation->status);
    }
}

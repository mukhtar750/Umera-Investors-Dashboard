<?php

namespace Tests\Feature;

use App\Models\Allocation;
use App\Models\Offering;
use App\Models\User;
use App\Notifications\NewInvestmentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InvestmentNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_legal_receive_notification_on_investment()
    {
        Notification::fake();

        // Create users
        $investor = User::factory()->create(['role' => 'investor', 'wallet_balance' => 100000]);
        $admin = User::factory()->create(['role' => 'admin']);
        $legal = User::factory()->create(['role' => 'legal']);

        // Create offering
        $offering = Offering::create([
            'name' => 'Test Offering',
            'price' => 1000,
            'min_investment' => 1000,
            'status' => 'open',
            'available_units' => 100,
        ]);

        // Act: Investor invests
        $response = $this->actingAs($investor)->post(route('investor.offerings.invest', $offering), [
            'units' => 10,
            'payment_method' => 'wallet',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        // Assert: Notification sent to Admin and Legal
        Notification::assertSentTo(
            [$admin, $legal],
            NewInvestmentNotification::class,
            function ($notification, $channels, $notifiable) {
                $data = $notification->toArray($notifiable);
                if ($notifiable->role === 'admin') {
                    return $data['url'] === route('admin.allocations.index');
                }
                if ($notifiable->role === 'legal') {
                    return $data['url'] === route('legal.dashboard');
                }
                return false;
            }
        );
    }
}

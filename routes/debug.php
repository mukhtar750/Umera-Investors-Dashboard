<?php

use App\Models\Offering;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/debug-import', function () {
    // Simulate data
    $processedRows = [
        [
            'name' => 'Debug User',
            'email' => 'debug.user@example.com',
            'land_name' => 'Debug Land',
            'investment_amount' => 100000,
            'block_name' => 'A',
            'unit_number' => '1',
            'total_paid' => 100000,
            'investment_date' => '2023-01-01',
        ],
    ];

    $now = now();

    // 1. Process Users
    $emails = collect($processedRows)->pluck('email')->filter()->unique()->toArray();
    $existingUsers = User::whereIn('email', $emails)->get()->keyBy('email');

    $usersToInsert = [];
    foreach ($emails as $email) {
        if (! $existingUsers->has($email)) {
            $row = collect($processedRows)->firstWhere('email', $email);
            $usersToInsert[] = [
                'name' => $row['name'] ?? 'Unknown',
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'investor',
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
    }

    if (! empty($usersToInsert)) {
        User::insert($usersToInsert);
    }

    $allUsers = User::whereIn('email', $emails)->get()->keyBy('email');

    // 2. Process Offerings
    $landNames = collect($processedRows)->pluck('land_name')->filter()->unique()->toArray();
    $existingOfferings = Offering::whereIn('name', $landNames)->get()->keyBy('name');

    $offeringsToInsert = [];
    foreach ($landNames as $name) {
        if (! $existingOfferings->has($name)) {
            $offeringsToInsert[] = [
                'name' => $name,
                'price' => 0,
                'total_units' => 100,
                'available_units' => 100,
                'status' => 'closed',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
    }

    if (! empty($offeringsToInsert)) {
        Offering::insert($offeringsToInsert);
    }

    $allOfferings = Offering::whereIn('name', $landNames)->get()->keyBy('name');

    // 3. Allocations
    $allocationsToInsert = [];

    foreach ($processedRows as $row) {
        $email = $row['email'];
        $landName = $row['land_name'];

        $user = $allUsers->get($email);
        $offering = $allOfferings->get($landName);

        if ($user && $offering) {
            $allocationsToInsert[] = [
                'user_id' => $user->id,
                'offering_id' => $offering->id,
                'amount' => $row['investment_amount'],
                'units' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        } else {
            dump("Missing: User ($email) ".($user ? 'Found' : 'Not Found').", Offering ($landName) ".($offering ? 'Found' : 'Not Found'));
        }
    }

    dump($allocationsToInsert);

    return 'Done';
});

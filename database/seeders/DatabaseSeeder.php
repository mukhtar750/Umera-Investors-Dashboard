<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@umera.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Investor User
        User::firstOrCreate(
            ['email' => 'investor@umera.com'],
            [
                'name' => 'Investor User',
                'password' => bcrypt('password'),
                'role' => 'investor',
                'email_verified_at' => now(),
            ]
        );

        // Legal User
        User::firstOrCreate(
            ['email' => 'legal@umera.com'],
            [
                'name' => 'Legal Team',
                'password' => bcrypt('password'),
                'role' => 'legal',
                'email_verified_at' => now(),
            ]
        );

        // Create some Offerings
        \App\Models\Offering::create([
            'name' => 'Umera Tech Fund I',
            'description' => 'A technology focused fund investing in early stage startups.',
            'target_amount' => 5000000,
            'min_investment' => 50000,
            'status' => 'open',
        ]);

        \App\Models\Offering::create([
            'name' => 'Umera Real Estate Fund',
            'description' => 'Prime real estate opportunities in metropolitan areas.',
            'target_amount' => 10000000,
            'min_investment' => 100000,
            'status' => 'coming_soon',
        ]);
    }
}

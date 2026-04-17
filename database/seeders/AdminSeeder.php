<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Seed or promote the primary admin account from environment variables.
     */
    public function run(): void
    {
        $email = trim((string) env('ADMIN_EMAIL', ''));
        $password = (string) env('ADMIN_PASSWORD', '');

        if ($email === '' || $password === '') {
            $this->command?->warn('Skipping AdminSeeder because ADMIN_EMAIL or ADMIN_PASSWORD is not set.');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'MarketVerse Admin'),
                'phone' => env('ADMIN_PHONE'),
                'address' => env('ADMIN_ADDRESS'),
                'usertype' => 'admin',
                'email_verified_at' => now(),
                'password' => Hash::make($password),
            ]
        );

        $this->command?->info("Admin account seeded for {$email}.");
    }
}


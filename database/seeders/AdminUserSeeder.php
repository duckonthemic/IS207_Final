<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@techparts.vn'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123456'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Test user
        User::firstOrCreate(
            ['email' => 'user@techparts.vn'],
            [
                'name' => 'Test User',
                'password' => Hash::make('user123456'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}

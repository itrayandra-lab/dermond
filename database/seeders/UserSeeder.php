<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@dermond.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create content manager user
        User::create([
            'name' => 'Content Manager',
            'username' => 'content',
            'email' => 'content@dermond.local',
            'password' => Hash::make('password'),
            'role' => 'content_manager',
            'email_verified_at' => now(),
        ]);

        // Create customer user
        User::create([
            'name' => 'Customer User',
            'username' => 'customer',
            'email' => 'customer@dermond.local',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}

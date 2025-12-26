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
        User::query()->updateOrCreate([
            'name' => 'Admin User',
            'username' => 'admin2',
            'email' => 'admin2@dermond.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // // Create content manager user
        // User::query()->updateOrCreate([
        //     'name' => 'Content Manager',
        //     'username' => 'content',
        //     'email' => 'content@dermond.local',
        //     'password' => Hash::make('password'),
        //     'role' => 'content_manager',
        //     'email_verified_at' => now(),
        // ]);

        // // Create customer user
        // User::query()->updateOrCreate([
        //     'name' => 'Customer User',
        //     'username' => 'customer',
        //     'email' => 'customer@dermond.local',
        //     'password' => Hash::make('password'),
        //     'role' => 'user',
        //     'email_verified_at' => now(),
        // ]);
    }
}

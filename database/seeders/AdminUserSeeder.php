<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@buzzin.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_admin' => 1
            ]
        );

        // Create some test users
        User::firstOrCreate(
            ['username' => 'user1'],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('BuzzIn@123'),
                'role' => 'user',
                'is_admin' => 0
            ]
        );

        User::firstOrCreate(
            ['username' => 'user2'],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('BuzzIn@123'),
                'role' => 'user',
                'is_admin' => 0
            ]
        );
    }
}

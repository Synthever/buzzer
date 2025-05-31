<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_seeder_creates_user_with_username()
    {
        $this->seed(\Database\Seeders\AdminUserSeeder::class);

        $user = User::first();

        $this->assertNotNull($user);
        $this->assertNotNull($user->username);
    }
}
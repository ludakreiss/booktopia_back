<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_there_is_built_in_user(): void
    {
        // Seed the database with a specific user
        User::factory()->create([
            'id' => 1,
            'name' => 'Default User',
            'email' => 'defaultuser@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Fetch the user by ID
        $user = User::where('id', 1)->first();

        // Assert that the user is an instance of the User model
        $this->assertInstanceOf(User::class, $user);
    }
}
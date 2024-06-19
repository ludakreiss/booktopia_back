<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful user logout.
     */
    public function test_user_logout_successful()
    {
        // Create a test user and log in to get a token
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => Hash::make('password123'),
        ]);

        $loginResponse = $this->postJson('/api/v1/login', [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertStatus(200);
        $token = $loginResponse->json('data.token');

        // Use the token to log out
        $logoutResponse = $this->withHeader('Authorization', 'Bearer ' . $token)
                              ->getJson('/api/v1/logout');

        $logoutResponse->assertStatus(200);
        $logoutResponse->assertJson([
            'status' => 'success'
        ]);
    }
}


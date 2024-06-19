<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful user login.
     */
    public function test_user_login_successful()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Attempt login with valid credentials
        $response = $this->postJson('/api/v1/login', [
            'email' => 'testuser@example.com',
            'password' => 'password123',
        ]);

        // Assert status is 200 OK
        $response->assertStatus(200);

        // Assert the structure of the response JSON
        $response->assertJsonStructure([
            'status',
            'data' => [
                'access_token',
                'token_type',
                'expires_in'
            ]
        ]);

        // Validate the token exists in the response
        $this->assertArrayHasKey('access_token', $response->json('data'));
    }

    /**
     * Test login fails with incorrect password.
     */
    public function test_user_login_fails_with_incorrect_password()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'testuser@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Unauthorized'
        ]);
    }

    /**
     * Test login fails with invalid email.
     */
    public function test_user_login_fails_with_invalid_email()
    {
        // Create a test user
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Unauthorized'
        ]);
    }
}

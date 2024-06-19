<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration success.
     */
    public function test_user_registration_successful()
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201); // Expecting a 201 status code
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    /**
     * Test registration fails with invalid email.
     */
    public function test_user_registration_fails_with_invalid_email(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // Expecting validation error with 422 status
        $response->assertStatus(422);
    }

    /**
     * Test registration fails with short password.
     */
    public function test_user_registration_fails_with_short_password(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        // Expecting validation error with 422 status
        $response->assertStatus(422);
    }

    /**
     * Test registration fails with mismatched passwords.
     */
    public function test_user_registration_fails_with_mismatched_passwords()
    {
        // Attempt to register with mismatched passwords
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password456', 
        ]);

        $response->assertStatus(201); // Expecting a 201 status code for successful registration

        // Now check that the user was created
        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
        ]);

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password)); // Check if the hashed password matches the original
    }
}

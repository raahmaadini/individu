<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * TEST 1: User can register
     * - Endpoint: POST /register
     * - Expected: User created, redirect to dashboard
     */
    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@test.com',
            'name' => 'Test User'
        ]);

        $response->assertRedirect('/dashboard');
    }

    /**
     * TEST 2: User can login
     * - Endpoint: POST /login
     * - Expected: Authenticated, redirect to dashboard
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@test.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/login', [
            'email' => 'test@test.com',
            'password' => 'password123'
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    /**
     * TEST 3: User can logout
     * - Endpoint: POST /logout
     * - Expected: Guest (not authenticated), redirect to home
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    /**
     * TEST 4: Login fails with wrong email
     * - Expected: Session has error
     */
    public function test_login_fails_with_invalid_email()
    {
        $response = $this->post('/login', [
            'email' => 'wrong@test.com',
            'password' => 'password123'
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * TEST 5: Register fails with duplicate email
     * - Expected: Session has error
     */
    public function test_register_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'test@test.com']);

        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'test@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    public function test_admin_signin()
    {
        $user = User::first();

        $response = $this->postJson(route('admin.signin'), [
            'email' => $user->email,
            'password' => 'Password@123',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'user' => [
                    'id',
                    'email',
                    'username',
                    'first_name',
                    'last_name',
                ],
                'message',
            ]);
    }

    public function test_admin_signout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->accessToken;

        $response = $this->postJson(route('admin.signout'), [], [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => __('auth.success_logout'),
            ]);
    }
}

<?php

namespace Tests\Feature\Website;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class WebsiteAuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('passport:install');
    }

    public function test_user_signup()
    {
        $country = Country::factory()->create();

        $data = [
            'country_id' => $country->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'blocked' => false,
            'phone' => [
                'country_code' => $country->code,
                'phone' => '022222112'
            ]
        ];

        $response = $this->postJson(route('website.signup'), $data);

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

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }

    public function test_user_signin()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('website.signin'), [
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

    public function test_user_verify_email()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->postJson(route('website.verify-email'), [
            'email' => $user->email,
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => __('auth.success_verify'),
            ]);

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_user_change_password()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $data = [
            'email' => $user->email,
            'current_password' => 'Password@123',
            'new_password' => 'NewPassword@123',
        ];

        $response = $this->postJson(route('website.change-password'), $data);

        $response->assertOk()
            ->assertJson([
                'message' => __('passwords.reset'),
            ]);

        $this->assertTrue(Hash::check('NewPassword@123', $user->fresh()->password));
    }

    public function test_user_signout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('Test Token')->accessToken;

        $response = $this->postJson(route('website.signout'), [], [
            'Authorization' => 'Bearer ' . $token
        ]);
        $response->assertOk()
            ->assertJson([
                'message' => __('auth.success_logout'),
            ]);
    }
}

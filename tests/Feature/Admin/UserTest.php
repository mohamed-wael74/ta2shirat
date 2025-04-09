<?php

namespace Tests\Feature\Admin;

use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\Country;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            $user->attachPermission($permission);
        }

        Passport::actingAs($user);
    }

    public function test_index()
    {
        $response = $this->getJson(route('admin.users.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'username',
                        'first_name',
                        'middle_name',
                        'last_name',
                        'phone' => [
                            'id',
                            'phone',
                        ],
                        'email',
                        'country' => [
                            'id',
                            'name',
                            'code',
                        ],
                    ],
                ],
            ]);
    }

    public function test_store()
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
                'phone' => '0111111111'
            ]
        ];


        $response = $this->postJson(route('admin.users.store'), $data);

        $response->assertOk()
            ->assertJson([
                'user' => [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $data['email'],
        ]);
    }

    public function test_show()
    {
        $user = User::factory()->create();

        $response = $this->getJson(route('admin.users.show', $user->id));

        $response->assertOk()
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                ]
            ]);
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $request = new UserUpdateRequest();
        $request->user = $user;

        $data = [
            'blocked' => 1,
        ];

        $response = $this->putJson(route('admin.users.update', $user->id), $data);

        $response->assertOk()
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                    'blocked' => 1
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_blocked' => 1,
        ]);
    }

    public function test_delete_route_does_not_exist()
    {
        $this->assertFalse(Route::has('admin.users.destroy'));
    }
}

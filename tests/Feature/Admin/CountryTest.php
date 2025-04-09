<?php

namespace Tests\Feature\Admin;

use App\Http\Requests\Admin\CountryUpdateRequest;
use App\Models\Country;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->getJson(route('admin.countries.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'code',
                        'flag',
                    ],
                ],
            ]);
    }

    public function test_show()
    {
        $country = Country::factory()->create();

        $response = $this->getJson(route('website.countries.show', $country->id));

        $response->assertOk()
            ->assertJson([
                'country' => [
                    'id' => $country->id,
                    'name' => $country->name,
                    'code' => $country->code,
                    'flag' => $country->flag,
                ]
            ]);
    }

    public function test_update()
    {
        $country = Country::factory()->create();

        $request = new CountryUpdateRequest();
        $request->country = $country;

        $data = [
            'locale' => app()->getLocale(),
            'available' => false,
        ];

        $response = $this->putJson(route('admin.countries.update', $country->id), $data);

        $response->assertOk()
            ->assertJson([
                'country' => [
                    'id' => $country->id,
                    'available' => false
                ],
            ]);

        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'is_available' => false,
        ]);
    }

    public function test_store_route_does_not_exist()
    {
        $this->assertFalse(Route::has('admin.countries.store'));
    }

    public function test_delete_route_does_not_exist()
    {
        $this->assertFalse(Route::has('admin.countries.destroy'));
    }
}

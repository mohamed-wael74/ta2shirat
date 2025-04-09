<?php

namespace Tests\Feature\Website;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $country = Country::factory(10)->create();

        $response = $this->getJson(route('website.countries.index'));

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

    public function test_store_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.countries.store'));
    }

    public function test_update_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.countries.update'));
    }

    public function test_delete_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.countries.destroy'));
    }
}

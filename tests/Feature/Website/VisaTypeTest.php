<?php

namespace Tests\Feature\Website;

use App\Models\User;
use App\Models\VisaType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class VisaTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        VisaType::factory(5)->create();

        $response = $this->getJson(route('website.visa-types.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }

    public function test_show()
    {
        $visaType = VisaType::factory()->create();

        $response = $this->getJson(route('website.visa-types.show', $visaType->id));

        $response->assertOk()
            ->assertJson([
                'visa_type' => [
                    'id' => $visaType->id,
                ],
            ]);
    }

    public function test_store_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.visa-types.store'));
    }

    public function test_update_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.visa-types.update'));
    }

    public function test_delete_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.visa-types.destroy'));
    }
}

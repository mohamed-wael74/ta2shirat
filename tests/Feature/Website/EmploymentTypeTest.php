<?php

namespace Tests\Feature\Website;

use App\Models\EmploymentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class EmploymentTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        EmploymentType::factory(5)->create();

        $response = $this->getJson(route('website.employment-types.index'));

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
        $employmentType = EmploymentType::factory()->create();

        $response = $this->getJson(route('website.employment-types.show', $employmentType->id));

        $response->assertOk()
            ->assertJson([
                'employment_type' => [
                    'id' => $employmentType->id,
                ],
            ]);
    }

    public function test_store_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.employment-types.store'));
    }

    public function test_update_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.employment-types.update'));
    }

    public function test_delete_route_does_not_exist()
    {
        $this->assertFalse(Route::has('website.employment-types.destroy'));
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Http\Requests\Admin\EmploymentTypeUpdateRequest;
use App\Models\EmploymentType;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Faker\Factory as Faker;

class EmploymentTypeTest extends TestCase
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
        EmploymentType::factory(5)->create();

        $response = $this->getJson(route('admin.employment-types.index'));

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

    public function test_store()
    {
        $data = [
            'name' => fake()->word() . ' emp'
        ];

        $response = $this->postJson(route('admin.employment-types.store'), $data);

        $response->assertOk()
            ->assertJson([
                'employment_type' => [
                    'name' => $data['name']
                ],
            ]);

        $this->assertDatabaseHas('employment_type_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_show()
    {
        $employmentType = EmploymentType::factory()->create();

        $response = $this->getJson(route('admin.employment-types.show', $employmentType->id));

        $response->assertOk()
            ->assertJson([
                'employment_type' => [
                    'id' => $employmentType->id,
                ],
            ]);
    }

    public function test_update()
    {
        $employmentType = EmploymentType::factory()->create();

        $request = new EmploymentTypeUpdateRequest();
        $request->employment_type = $employmentType;

        $data = [
            'locale' => app()->getLocale(),
            'name' => fake()->word() . ' emp'
        ];

        $response = $this->putJson(route('admin.employment-types.update', $employmentType->id), $data);

        $response->assertOk()
            ->assertJson([
                'employment_type' => [
                    'id' => $employmentType->id,
                    'name' => $data['name']
                ],
            ]);

        $this->assertDatabaseHas('employment_type_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_destroy()
    {
        $employmentType = EmploymentType::factory()->create();

        $response = $this->deleteJson(route('admin.employment-types.destroy', $employmentType->id));

        $response->assertOk()
            ->assertJson([
                'message' => __('employment_types.destroy'),
            ]);

        $this->assertDatabaseMissing('employment_types', [
            'id' => $employmentType->id
        ]);
    }
}

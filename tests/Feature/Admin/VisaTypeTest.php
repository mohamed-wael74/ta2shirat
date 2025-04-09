<?php

namespace Tests\Feature\Admin;

use App\Http\Requests\Admin\VisaTypeUpdateRequest;
use App\Models\Permission;
use App\Models\User;
use App\Models\VisaType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class VisaTypeTest extends TestCase
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
        VisaType::factory(5)->create();

        $response = $this->getJson(route('admin.visa-types.index'));

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
            'name' => fake()->word() . ' vis'
        ];

        $response = $this->postJson(route('admin.visa-types.store'), $data);

        $response->assertOk()
            ->assertJson([
                'visa_type' => [
                    'name' => $data['name']
                ],
            ]);

        $this->assertDatabaseHas('visa_type_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_show()
    {
        $visaType = VisaType::factory()->create();

        $response = $this->getJson(route('admin.visa-types.show', $visaType->id));

        $response->assertOk()
            ->assertJson([
                'visa_type' => [
                    'id' => $visaType->id,
                ],
            ]);
    }

    public function test_update()
    {
        $visaType = VisaType::factory()->create();

        $request = new VisaTypeUpdateRequest();
        $request->visa_type = $visaType;

        $data = [
            'locale' => app()->getLocale(),
            'name' => fake()->word() . ' vis'
        ];

        $response = $this->putJson(route('admin.visa-types.update', $visaType->id), $data);

        $response->assertOk()
            ->assertJson([
                'visa_type' => [
                    'id' => $visaType->id,
                    'name' => $data['name']
                ],
            ]);

        $this->assertDatabaseHas('visa_type_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_destroy()
    {
        $visaType = VisaType::factory()->create();

        $response = $this->deleteJson(route('admin.visa-types.destroy', $visaType->id));

        $response->assertOk()
            ->assertJson([
                'message' => __('visa_types.destroy'),
            ]);

        $this->assertDatabaseMissing('visa_types', [
            'id' => $visaType->id
        ]);
    }
}

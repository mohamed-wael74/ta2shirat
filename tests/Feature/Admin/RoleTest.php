<?php

namespace Tests\Feature\Admin;

use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RoleTest extends TestCase
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
        $response = $this->getJson(route('admin.roles.index'));

        $response->assertOk()
            ->assertJsonCount(1, 'data');
    }

    public function test_store()
    {
        $permissions = Permission::factory(2)->create()->pluck('id')->toArray();

        $data = [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'permissions' => $permissions
        ];

        $response = $this->postJson(route('admin.roles.store'), $data);

        $response->assertOk()
            ->assertJson([
                'role' => [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            ]);

        $this->assertDatabaseHas('role_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_show()
    {
        $role = Role::factory()->create();

        $response = $this->getJson(route('admin.roles.show', $role->id));

        $response->assertOk()
            ->assertJson([
                'role' => [
                    'id' => $role->id,
                ]
            ]);
    }

    public function test_update()
    {
        $role = Role::factory()->create();
        $permissions = Permission::factory(2)->create()->pluck('id')->toArray();

        $request = new RoleUpdateRequest();
        $request->role = $role;

        $data = [
            'locale' => app()->getLocale(),
            'name' => fake()->word() . 'rol',
            'description' => fake()->sentence(),
            'permissions' => $permissions
        ];

        $response = $this->putJson(route('admin.roles.update', $role->id), $data);

        $response->assertOk()
            ->assertJson([
                'role' => [
                    'name' => $data['name'],
                    'description' => $data['description']
                ]
            ]);

        $this->assertDatabaseHas('role_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_it_cannot_update_main_role()
    {
        $role = Role::first();
        $permissions = Permission::factory(2)->create()->pluck('id')->toArray();

        $data = [
            'locale' => app()->getLocale(),
            'name' => fake()->word() . 'rol',
            'description' => fake()->sentence(),
            'permissions' => $permissions
        ];

        $response = $this->putJson(route('admin.roles.update', $role->id), $data);

        $response->assertStatus(403)
            ->assertJson([
                'message' => __('roles.cant_update_superadmin')
            ]);
    }

    public function test_destroy()
    {
        $role = Role::factory()->create();

        $response = $this->deleteJson(route('admin.roles.destroy', $role->id));

        $response->assertOk()
            ->assertJson([
                'message' => __('roles.destroy'),
            ]);

        $this->assertDatabaseMissing('roles', [
            'id' => $role->id
        ]);
    }

    public function test_it_cannot_destroy_main_role()
    {
        $role = Role::first();

        $response = $this->deleteJson(route('admin.roles.destroy', $role->id));

        $response->assertStatus(403)
            ->assertJson([
                'message' => __('roles.cant_destroy_superadmin')
            ]);
    }
}

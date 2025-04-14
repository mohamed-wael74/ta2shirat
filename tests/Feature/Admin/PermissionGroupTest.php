<?php

namespace Tests\Feature\Admin;

use App\Http\Requests\Admin\PermissionGroupUpdateRequest;
use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PermissionGroupTest extends TestCase
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
        $response = $this->getJson(route('admin.permission-groups.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description'
                    ],
                ],
            ]);
    }

    public function test_store()
    {
        $permissions = Permission::factory(2)->create()->pluck('id')->toArray();

        $data = [
            'name' => $this->faker->word . 'group',
            'permissions' => $permissions
        ];

        $response = $this->postJson(route('admin.permission-groups.store'), $data);

        $response->assertOk()
            ->assertJson([
                'permission_group' => [
                    'name' => $data['name']
                ],
            ]);

        $this->assertDatabaseHas('permission_group_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_show()
    {
        $permissionGroup = PermissionGroup::factory()->create();

        $response = $this->getJson(route('admin.permission-groups.show', $permissionGroup->id));

        $response->assertOk()
            ->assertJson([
                'permission_group' => [
                    'id' => $permissionGroup->id,
                ],
            ]);
    }

    public function test_update()
    {
        $permissionGroup = PermissionGroup::factory()->create();
        $existingGroupPermissions = $permissionGroup->permissions->pluck('id')->toArray();
        $newPermissions = Permission::factory(2)->create()->pluck('id')->toArray();

        $permissions = array_merge($existingGroupPermissions, $newPermissions);

        $request = new PermissionGroupUpdateRequest();
        $request->permission_group = $permissionGroup;

        $data = [
            'locale' => app()->getLocale(),
            'name' => $this->faker->word . 'group',
            'permissions' => $permissions
        ];

        $response = $this->putJson(route('admin.permission-groups.update', $permissionGroup->id), $data);

        $response->assertOk()
            ->assertJson([
                'permission_group' => [
                    'id' => $permissionGroup->id,
                    'name' => $data['name']
                ],
            ]);

        $this->assertDatabaseHas('permission_group_translations', [
            'name' => $data['name']
        ]);
    }

    public function test_destroy()
    {
        $permissionGroup = PermissionGroup::factory()->create();

        $permissions = Permission::factory(3)->create();

        $permissionGroup->permissions()->attach($permissions);

        $permissionGroup->permissions()->detach();

        $response = $this->deleteJson(route('admin.permission-groups.destroy', $permissionGroup->id));


        $response->assertOk()
            ->assertJson([
                'message' => __('permission_groups.destroy'),
            ]);

        $this->assertDatabaseMissing('permission_groups', [
            'id' => $permissionGroup->id
        ]);
    }

    public function test_it_cannot_destroy_permission_group_while_not_empty()
    {
        $permissionGroup = PermissionGroup::factory()->create();
        $permissions = Permission::factory(2)->create();

        $permissionGroup->permissions()->attach($permissions);

        $response = $this->deleteJson(route('admin.permission-groups.destroy', $permissionGroup->id));

        $response->assertStatus(400)
            ->assertJson([
                'message' => __('permission_groups.cant_destroy'),
            ]);
    }
}

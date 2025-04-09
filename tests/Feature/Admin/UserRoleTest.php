<?php

namespace Tests\Feature\Admin;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserRoleTest extends TestCase
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

    public function test_update()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->putJson(route('admin.users.roles.update', [$user->id, $role->id]), [
            'role' => $role->id,
        ]);

        $response->assertOk()
            ->assertJson([
                'User' => [
                    'id' => $user->id,
                ],
                'message' => __('users.roles.update'),
            ]);

        $this->assertDatabaseHas('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);
    }

    public function test_it_cannot_update_super_admin_role()
    {
        $user = User::first();
        $role = Role::factory()->create();

        $response = $this->putJson(route('admin.users.roles.update', [$user->id, $role->id]), [
            'role' => $role->id,
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'message' => __('roles.cant_update_superadmin'),
            ]);
    }

    public function test_destroy()
    {
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $response = $this->deleteJson(route('admin.users.roles.destroy', [$user->id, $role->id]));

        $response->assertOk()
            ->assertJsonStructure([
                'User',
                'message',
            ]);

        $this->assertDatabaseMissing('role_user', [
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);
    }

    public function test_it_cannot_destroy_super_admin_role()
    {
        $user = User::first();
        $role = Role::first();

        $response = $this->deleteJson(route('admin.users.roles.destroy', [$user->id, $role->id]));

        $response->assertStatus(403)
            ->assertJsonStructure([
                'message',
            ]);
    }
}

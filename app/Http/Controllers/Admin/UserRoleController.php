<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRoleUpdateRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;

class UserRoleController extends Controller
{
    public function update(UserRoleUpdateRequest $request, User $user, Role $role)
    {
        $this->authorize('update', RoleUser::class);

        if (! $request->updateUserRole()) {
            return response([
                'message' => __('roles.cant_update_superadmin')
            ], 403);
        }

        return response([
            'message' => __('users.roles.update'),
            'User' => new UserResource($user),
        ]);
    }

    public function destroy(User $user, Role $role)
    {
        $this->authorize('delete', RoleUser::class);

        if ($user->isSuperAdmin() && $role->isMainRole()) {
            return response([
                'message' => __('users.roles.cant_destroy_superadmin')
            ], 403);
        }

        $user->removeRoleAndPermissions($role);
        return response([
            'message' => __('users.roles.destroy'),
            'User' => new UserResource($user),
        ]);
    }
}

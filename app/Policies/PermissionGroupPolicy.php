<?php

namespace App\Policies;

use App\Models\PermissionGroup;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionGroupPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('permission_groups-read');
    }

    public function view(User $user, PermissionGroup $permissionGroup)
    {
        return $user->hasPermission('permission_groups-read');
    }

    public function create(User $user)
    {
        return $user->hasPermission('permission_groups-create');
    }

    public function update(User $user, PermissionGroup $permissionGroup)
    {
        return $user->hasPermission('permission_groups-update');
    }

    public function delete(User $user, PermissionGroup $permissionGroup)
    {
        return $user->hasPermission('permission_groups-delete');
    }
}

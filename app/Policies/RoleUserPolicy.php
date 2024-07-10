<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoleUserPolicy
{
    use HandlesAuthorization;

    public function update(User $user)
    {
        return $user->hasPermission('role_user-create');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('role_user-delete');
    }
}

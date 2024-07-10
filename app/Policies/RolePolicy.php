<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('roles-read');
    }

    public function view(User $user)
    {
        return $user->hasPermission('roles-read');
    }

    public function create(User $user)
    {
        return $user->hasPermission('roles-create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('roles-update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('roles-delete');
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('users-read');
    }

    public function view(User $user, User $model)
    {
        return $user->hasPermission('users-read');
    }

    public function create(User $user)
    {
        return $user->hasPermission('users-create');
    }

    public function update(User $user, User $model)
    {
        return $user->hasPermission('users-update');
    }
}

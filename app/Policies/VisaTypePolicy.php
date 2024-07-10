<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VisaTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('visa_types-read');
    }

    public function view(User $user)
    {
        return $user->hasPermission('visa_types-read');
    }

    public function create(User $user)
    {
        return $user->hasPermission('visa_types-create');
    }

    public function update(User $user)
    {
        return $user->hasPermission('visa_types-update');
    }

    public function delete(User $user)
    {
        return $user->hasPermission('visa_types-delete');
    }
}

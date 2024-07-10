<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('countries-read');
    }

    public function view(User $user)
    {
        return $user->hasPermission('countries-read');
    }

    public function update(User $user)
    {
        return $user->hasPermission('countries-update');
    }
}

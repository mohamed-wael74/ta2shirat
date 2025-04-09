<?php

namespace App\Policies;

use App\Models\SellingVisa;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellingVisaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('selling_visas-read');
    }

    public function view(User $user, SellingVisa $sellingVisa)
    {
        return $user->hasPermission('selling_visas-read');
    }

    public function update(User $user, SellingVisa $sellingVisa)
    {
        return $user->hasPermission('selling_visas-update');
    }
}

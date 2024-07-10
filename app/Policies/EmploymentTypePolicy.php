<?php

namespace App\Policies;

use App\Models\EmploymentType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmploymentTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermission('employment_types-read');
    }

    public function view(User $user, EmploymentType $employmentType)
    {
        return $user->hasPermission('employment_types-read');
    }

    public function create(User $user)
    {
        return $user->hasPermission('employment_types-create');
    }

    public function update(User $user, EmploymentType $employmentType)
    {
        return $user->hasPermission('employment_types-update');
    }

    public function delete(User $user, EmploymentType $employmentType)
    {
        return $user->hasPermission('employment_types-delete');
    }
}

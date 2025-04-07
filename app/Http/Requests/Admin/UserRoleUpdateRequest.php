<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UserRoleUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'role' => 'required|integer|exists:roles,id',
        ];
    }

    public function updateUserRole(): bool
    {
        if ($this->user->isSuperAdmin()) {
            return false;
        }

        return DB::transaction(function () {
            $role = Role::find($this->role);

            $this->user->syncRoles([$role->id]);
            $this->user->syncPermissions($role->permissions->pluck('id')->toArray());

            return true;
        });
    }
}

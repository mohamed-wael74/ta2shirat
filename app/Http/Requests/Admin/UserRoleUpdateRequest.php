<?php

namespace App\Http\Requests\Admin;

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
            //
        ];
    }

    public function updateUserRole(): bool
    {
        if ($this->user->isSuperAdmin()) {
            return false;
        }

        return DB::transaction(function () {
            $this->user->syncRoles([$this->role->id]);
            $this->user->syncPermissions($this->role->permissions->pluck('id')->toArray());

            return true;
        });
    }
}

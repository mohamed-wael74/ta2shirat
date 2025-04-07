<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class RoleStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:50|unique:role_translations,name',
            'description' => 'sometimes|string|min:2|max:255',
            'permissions' => 'required|array|min:1|distinct',
            'permissions.*' => 'required|integer|exists:permissions,id',
        ];
    }

    public function storeRole(): Role
    {
        return DB::transaction(function () {
            $role = Role::create();

            $role->translations()->create([
                'locale' => config('app.fallback_locale'),
                'name' => $this->name,
                'description' => $this->description
            ]);

            $role->attachPermissions($this->permissions);

            return $role;
        });
    }
}

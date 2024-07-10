<?php

namespace App\Http\Requests\Admin;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\PermissionGroupPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class PermissionGroupStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|min:5|max:50',
            'description' => 'sometimes|string|min:5|max:255',
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|exists:permissions,id',
        ];
    }

    public function storePermissionGroup()
    {
        return DB::transaction(function () {
            $permissionGroup = PermissionGroup::create();
            $permissionGroup->translations()->create([
                'locale' => config('app.fallback_locale'),
                'name' => $this->name,
                'description' => $this->description
            ]);
            PermissionGroupPermission::whereIn('permission_id', $this->permissions)->delete();
            $permissionGroup->permissions()->sync($this->permissions);
            return $permissionGroup->refresh();
        });
    }
}

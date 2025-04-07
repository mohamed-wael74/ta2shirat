<?php

namespace App\Http\Requests\Admin;

use App\Models\PermissionGroupPermission;
use Illuminate\Foundation\Http\FormRequest;


class PermissionGroupUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $supportedLocales = implode(',', array_keys(config('localization.supportedLocales')));

        return [
            'locale' => 'required|string|in:' . $supportedLocales,
            'name' => 'sometimes|string|min:5|max:50',
            'description' => 'sometimes|string|min:5|max:255',
            'permissions' => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    if (!empty(array_diff($this->permission_group->permissions->pluck('id')->toArray(), $this->permissions))) {
                        $fail(__('permission_groups.missing'));
                    }
                }
            ],
            'permissions.*' => 'required|exists:permissions,id',
        ];
    }

    public function updatePermissionGroup()
    {
        $this->updatePermissionGroupTranslation();

        PermissionGroupPermission::whereIn('permission_id', $this->permissions)
            ->where('permission_group_id', '!=', $this->permission_group->id)
            ->delete();
        $this->permission_group->permissions()->sync($this->permissions);
        return $this->permission_group->refresh();
    }

    public function updatePermissionGroupTranslation()
    {
        $this->permission_group->translations()->updateOrCreate(
            [
                'locale' => $this->validated('locale')
            ],
            [
                'name' => $this->exists('name') ? $this->name : $this->permission_group->name,
                'description' => $this->exists('description') ? $this->description : $this->permission_group->description,
            ]
        );
    }
}

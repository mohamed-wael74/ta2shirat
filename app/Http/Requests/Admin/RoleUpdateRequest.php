<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class RoleUpdateRequest extends FormRequest
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
            'name' => 'sometimes|string|min:2|max:50|unique:role_translations,name,' . $this->role->id . ',role_id',
            'description' => 'sometimes|string|min:2|max:255',
            'permissions' => 'sometimes|array|min:1|distinct',
            'permissions.*' => 'required_with:permissions|integer|exists:permissions,id',
        ];
    }

    public function updateRole()
    {
        if ($this->role->isMainRole()) {
            abort(403, __('roles.cant_update_superadmin'));
        }

        DB::transaction(function () {
            if ($this->hasAny(['name', 'description'])) {
                $this->updateRoleTranslations();
            }

            $this->whenHas('permissions', function () {
                $this->updateRolePermissions();
            });

            return $this->role->refresh();
        });
    }

    protected function updateRoleTranslations()
    {
        $this->role->translations()->updateOrCreate(
            ['locale' => $this->input('locale')],
            [
                'name' => $this->name ?? $this->role->name,
                'description' => $this->description ?? $this->role->description
            ]
        );
    }

    protected function updateRolePermissions()
    {
        if ($this->role->isMainRole()) {
            abort(403, __('roles.cant_update_superadmin'));
        }

        if ($this->inputHasAlteredPermissions()) {
            $this->role->syncPermissions($this->permissions);
            $this->role->users->each->syncPermissions($this->permissions);
        }
    }

    protected function inputHasAlteredPermissions(): bool
    {
        return !empty(array_diff($this->permissions, $this->role->permissions->pluck('id')->toArray())) ||
            !empty(array_diff($this->role->permissions->pluck('id')->toArray(), $this->permissions));
    }
}

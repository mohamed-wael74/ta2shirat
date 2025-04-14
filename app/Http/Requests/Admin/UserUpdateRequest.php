<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'blocked' => 'required|boolean',
        ];
    }

    public function updateUser()
    {
        if ($this->user->id === auth()->id()) {
            abort(403, __('users.cant_block_yourself'));
        }

        if ($this->user->isSuperAdmin()) {
            abort(403, __('users.cant_block_superadmin'));
        }

        return $this->user->update([
            'is_blocked' => $this->blocked,
        ]);
    }
}

<?php

namespace App\Http\Requests\Website;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public $user;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->user = User::where('email', $this->email)->first();

        return [
            'email' => [
                'required',
                'string',
                'email',
                function ($attribute, $value, $fail) {
                    if (!$this->user) {
                        $fail(__('auth.failed_login'));
                    }
                }
            ],
            'current_password' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user->password)) {
                        $fail(__('auth.failed_login'));
                    }
                },
            ],
            'new_password' => [
                'required',
                'string',
                Password::default(),
            ],
        ];
    }

    public function changePassword()
    {
        $this->user->update([
            'password' => bcrypt($this->new_password)
        ]);
        
        return true;
    }
}

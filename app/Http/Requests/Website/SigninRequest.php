<?php

namespace App\Http\Requests\Website;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SigninRequest extends FormRequest
{
    public $user;

    public function authorize()
    {
        return true;
    }

    public function rules(): array
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
                },
                function ($attribute, $value, $fail) {
                    if ($this->user?->is_blocked) {
                        $fail(__('auth.blocked_account'));
                    }
                }
            ],
            'password' => [
                'required',
                'string',
                Password::default(),
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user->password))
                        $fail(__('auth.failed_login'));
                }
            ],
        ];
    }

    public function signin()
    {
        $accessToken = $this->user->createToken('User Login Token');
        return [
            'user' => $this->user,
            'access_token' => $accessToken
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        if (!$this->user->roles()->exists()) {
            throw new NotFoundHttpException;
        }

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
        $accessToken = $this->user->createToken('Admin Login Token');
        
        return [
            'user' => $this->user,
            'access_token' => $accessToken
        ];
    }
}

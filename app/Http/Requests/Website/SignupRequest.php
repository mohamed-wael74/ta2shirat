<?php

namespace App\Http\Requests\Website;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
            'firstname' => 'required|string|min:2|max:20',
            'lastname' => 'required|string|min:2|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                Password::default()
            ],
            'phone' => 'required|array',
            'phone.country_code' => 'required|string|exists:countries,code',
            'phone.phone' => 'required|numeric|digits_between:9,15'
        ];
    }

    public function register()
    {
        return DB::transaction(function () {
            $user = User::create([
                'country_id' => $this->country_id,
                'username' => User::generateUsername($this->email),
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'password' => bcrypt($this->password),
            ]);
            $user->addPhone($this->phone);
            $accessToken = $user->createToken('Register Token');
            return [
                'user' => $user,
                'access_token' => $accessToken
            ];
        });
    }
}

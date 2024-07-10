<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'country_id' => ['required', 'integer', Rule::exists('countries', 'id')->where('is_available', true)],
            'firstname' => ['required', 'string', 'min:2', 'max:20'],
            'middlename' => ['sometimes', 'string', 'min:2', 'max:20'],
            'lastname' => ['required', 'string', 'min:2', 'max:20'],
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users')
                    ->whereNull('deleted_at')
                    ->whereNotNull('email_verified_at')
            ],
            'password' => ['required', 'string', 'confirmed', Password::default()],
            'birthdate' => ['sometimes', 'date'],
            'blocked' => ['sometimes', 'boolean'],
            'phone' => ['required', 'array', 'max:3'],
            'phone.country_code' => ['required', 'string', 'exists:countries,code'],
            'phone.phone' => ['required', 'numeric', 'digits_between:9,15'],
            'phone.type' => ['sometimes', 'string', 'max:10'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function storeUser(): User
    {
        return DB::transaction(function () {
            $user = $this->storeUserData();

            $this->storePhoneData($user);

            $this->whenHas('image', function (UploadedFile $image) use ($user) {
                $this->storeUserImage($user, $image);
            });

            return $user;
        });
    }

    protected function storeUserData(): User
    {
        return User::create(
            $this->safe()->merge([
                'username' => User::generateUsername($this->email),
                'is_blocked' => $this->blocked,
                'password' => bcrypt($this->password),
            ])->all()
        );
    }

    protected function storePhoneData($user): void
    {
        $user->addPhone([
            'country_code' => $this->phone['country_code'],
            'phone' => $this->phone['phone'],
            'type' => $this->phone['type'] ?? null
        ]);
    }

    protected function storeUserImage($user, $image): void
    {
        $user->medium()->create([
            'name' => $image->getClientOriginalName(),
            'type' => 'photo',
            'size' => $image->getSize() / 1024,
            'path' => $user->uploadMedium($image, 'uploads/users'),
            'is_main' => true,
        ]);
    }
}

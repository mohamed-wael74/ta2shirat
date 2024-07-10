<?php

namespace App\Http\Requests\Website;

use App\Mail\MailVerified;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    protected $user;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->user = Auth::user();

        return [
            'country_id' => ['sometimes', 'integer', Rule::exists('countries', 'id')->where('is_available', true)],
            'firstname' => ['sometimes', 'string', 'min:2', 'max:20'],
            'middlename' => ['sometimes', 'string', 'min:2', 'max:20'],
            'lastname' => ['sometimes', 'string', 'min:2', 'max:20'],
            'email' => [
                'sometimes',
                'email',
                'max:50',
                Rule::unique('users')
                    ->ignore($this->user->id)
                    ->whereNull('deleted_at')
                    ->whereNotNull('email_verified_at')
            ],
            'birthdate' => ['sometimes', 'date'],
            'phone' => ['sometimes', 'array', 'max:3'],
            'phone.country_code' => ['sometimes', 'string', 'exists:countries,code'],
            'phone.phone' => ['sometimes', 'numeric', 'digits_between:9,15'],
            'phone.type' => ['sometimes', 'string', 'max:10'],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function updateUser(): User
    {
        return DB::transaction(function () {
            $this->updateUserData();

            $this->whenHas('phone', function (array $phone) {
                $this->updatePhoneData($phone);
            });

            $this->whenHas('image', function (UploadedFile $image) {
                $this->updateUserImage($image);
            });

            return $this->user->fresh();
        });
    }

    protected function updatePhoneData(array $phone): void
    {
        if ($this->exists('phone.phone') && $phone['phone'] !== $this->user->phone->phone ||
            $phone['country_code'] !== $this->user->country_id) {
            $this->user->update(['phone_verified_at' => null]);
        }

        $this->user->phone()->update(
            [
                'country_code' => $phone['country_code'],
                'type' => $phone['type'],
                'phone' => $phone['phone']
            ]
        );
    }

    protected function updateUserData(): void
    {
        if ($this->exists('email') && $this->email !== $this->user->email) {
            $this->user->update(['email_verified_at' => null]);
            $this->user->createEmailToken($this->email);
            Mail::to($this->email)->send(new MailVerified($this->user));

        }

        $this->user->update($this->validated());
    }

    protected function updateUserImage($image): void
    {
        if ($this->user->main_image) {
            $imagePath = $this->user->updateMedium($image, $this->user->main_image, 'uploads/users');
            $this->createMedium($image, $imagePath);
        } else {
            $this->createMedium($image);
        }
    }

    protected function createMedium(UploadedFile $image, $imagePath = null)
    {
        return $this->user->medium()->create([
            'name' => $image->getClientOriginalName(),
            'type' => 'photo',
            'size' => $image->getSize() / 1024,
            'path' => $imagePath ?? $this->user->uploadMedium($image, 'uploads/users'),
            'is_main' => true,
        ]);
    }
}

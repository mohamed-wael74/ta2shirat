<?php

namespace App\Http\Requests\Website;

use App\Mail\MailVerified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyEmailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = Auth::user();

        return [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($user) {
                    if ($user && $user->email === $value && $user->email_verified_at !== null) {
                        $fail(__('auth.success_verify'));
                    }
                },
            ],
        ];
    }

    public function verifyEmail()
    {
        return DB::transaction(function () {
            $user = Auth::user();
            $this->createEmailToken($user);
            $this->sendMail($user);
            $user->email_verified_at = now();
            $user->save();
            return true;
        });
    }

    public function createEmailToken($user)
    {
        $user->emailToken()->create([
            'user_id' => $user->id,
            'email' => $user->email,
            'token' => Hash::make(Str::random(20))
        ]);
    }

    public function sendMail($user)
    {
        Mail::to($user->email)->send(new MailVerified($user));
    }
}

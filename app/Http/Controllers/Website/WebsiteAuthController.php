<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ChangePasswordRequest;
use App\Http\Requests\Website\SigninRequest;
use App\Http\Requests\Website\SignupRequest;
use App\Http\Requests\Website\VerifyEmailRequest;
use App\Http\Resources\Website\UserResource;
use Illuminate\Support\Facades\Auth;

class WebsiteAuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $response = $request->register();

        return response([
            'message' => __('auth.success_register'),
            'access_token' => $response['access_token'],
            'user' => new UserResource($response['user']),
        ]);
    }

    public function signin(SigninRequest $request)
    {
        $response = $request->signin();

        return response([
            'message' => __('auth.success_login'),
            'access_token' => $response['access_token'],
            'user' => new UserResource($response['user']),
        ]);
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        $request->verifyEmail();

        return response([
            'message' => __('auth.success_verify')
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $request->changePassword();

        return response([
            'message' => __('passwords.reset')
        ]);
    }

    public function signout()
    {
        $user = Auth::user();
        $user->token()->revoke();

        return response([
            'message' => __('auth.success_logout')
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SigninRequest;
use App\Http\Resources\Admin\UserResource;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function signin(SigninRequest $request)
    {
        $response = $request->signin();

        return response([
            'access_token' => $response['access_token'],
            'user' => new UserResource($response['user']),
            'message' => __('auth.success_login')
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

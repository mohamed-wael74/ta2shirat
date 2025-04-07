<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\UserUpdateRequest;
use App\Http\Resources\Website\UserResource;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        return response([
            'user' => new UserResource(Auth::user()),
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = $request->updateUser();

        return response([
            'message' => __('users.update'),
            'user' => new UserResource($user),
        ]);
    }

    public function destroy()
    {
        if (Auth::user()->isSuperAdmin()) {
            return response([
                'message' => __('users.cant_destroy')
            ], 403);
        }

        Auth::user()->tokens()->delete();
        Auth::user()->delete();

        return response([
            'message' => __('users.destroy')
        ]);
    }
}

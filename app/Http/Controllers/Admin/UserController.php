<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(UserFilter $filters)
    {
        $paginationLength = pagination_length('user');

        return UserResource::collection(
            User::with(['country', 'media', 'phone', 'roles'])->filter($filters)->paginate($paginationLength)
        );
    }

    public function store(UserStoreRequest $request)
    {
        $user = $request->storeUser();

        return response([
            'user' => UserResource::make($user),
            'message' => __('users.store')
        ]);
    }

    public function show(User $user)
    {
        return response([
            'user' => UserResource::make($user)
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $request->updateUser();

        return response([
            'user' => UserResource::make($user),
            'message' => __('users.update')
        ]);
    }
}

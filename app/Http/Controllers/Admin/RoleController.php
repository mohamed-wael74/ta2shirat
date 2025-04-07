<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleStoreRequest;
use App\Http\Requests\Admin\RoleUpdateRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Resources\Admin\RoleSimpleResource;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        $roles = Role::paginate();
        return RoleSimpleResource::collection($roles);
    }

    public function store(RoleStoreRequest $request)
    {
        $role = $request->storeRole();

        return response([
            'message' => __('roles.store'),
            'role' => new RoleResource($role),
        ]);
    }

    public function show(Role $role)
    {
        return response([
            'role' => new RoleResource($role)
        ]);
    }

    public function update(RoleUpdateRequest $request, Role $role)
    {
        $request->updateRole();

        return response([
            'message' => __('roles.update'),
            'role' => new RoleResource($role),
        ]);
    }

    public function destroy(Role $role)
    {
        if (!$role->remove()) {
            return response([
                'message' => __('roles.cant_destroy_superadmin')
            ], 403);
        }

        return response([
            'message' => __('roles.destroy')
        ]);
    }
}

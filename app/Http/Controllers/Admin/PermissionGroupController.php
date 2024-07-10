<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionGroupStoreRequest;
use App\Http\Requests\Admin\PermissionGroupUpdateRequest;
use App\Http\Resources\Admin\PermissionGroupResource;
use App\Http\Resources\Admin\PermissionGroupSimpleResource;
use App\Models\PermissionGroup;
use App\Models\User;

class PermissionGroupController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PermissionGroup::class, 'permission_group');
    }

    public function index()
    {
        return PermissionGroupSimpleResource::collection(PermissionGroup::paginate());
    }

    public function show(PermissionGroup $permissionGroup)
    {
        return response([
            'permission_group' => new PermissionGroupResource($permissionGroup)
        ]);
    }

    public function store(PermissionGroupStoreRequest $request)
    {
        return response([
            'permission_group' => new PermissionGroupResource($request->storePermissionGroup()),
            'message' => __('permission_groups.store')
        ]);
    }

    public function update(PermissionGroupUpdateRequest $request, PermissionGroup $permissionGroup)
    {
        $request->updatePermissionGroup();
        return response([
            'permission_group' => new PermissionGroupResource($permissionGroup),
            'message' => __('permission_groups.update')
        ]);
    }

    public function destroy(PermissionGroup $permissionGroup)
    {
        if ($permissionGroup->permissions()->exists()) {
            return response([
                'message' => __('permission_groups.cant_destroy')
            ], 400);
        }

        $permissionGroup->remove();
        return response([
            'message' => __('permission_groups.destroy')
        ]);
    }
}

<?php

namespace App\Http\Resources\Admin;

use App\Models\PermissionGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'permission_groups' => PermissionGroup::all()->map(function ($permissionGroup) {
                return new PermissionGroupResource($permissionGroup, $this);
            })
        ];
    }
}

<?php

namespace App\Http\Resources\Admin;

use App\Models\Permission;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionGroupResource extends JsonResource
{
    protected $parent;

    public function __construct($resource, $parent = null)
    {
        parent::__construct($resource);
        $this->parent = $parent;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'permissions' => $this->parent ?
                $this->permissions->map(function ($permission) {
                    return new PermissionResource($permission, $this->parent);
                }) : Permission::all()->map(function ($permission) {
                    return new PermissionResource($permission, $this);
                })
        ];
    }
}

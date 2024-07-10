<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    protected $parent;

    public function __construct($resource, $parent)
    {
        parent::__construct($resource);
        $this->parent = $parent;
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'description' => $this->description,
            'selected' => $this->parent->permissions->contains('id', $this->id),
        ];
    }
}

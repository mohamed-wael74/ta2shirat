<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    use HasFactory;

    public $fillable = [
        'name',
        'display_name',
        'description',
    ];

    public function permissionGroups()
    {
        return $this->belongsToMany(PermissionGroup::class, 'permission_group_permission');
    }

    public function permissionGroupPermissions()
    {
        return $this->hasMany(PermissionGroupPermission::class, 'permission_id');
    }
}

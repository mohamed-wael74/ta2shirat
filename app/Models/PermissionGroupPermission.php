<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroupPermission extends Model
{
    use HasFactory;

    protected $table = 'permission_group_permission';

    protected $fillable = [
        'permission_group_id',
        'permission_id',
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }
}

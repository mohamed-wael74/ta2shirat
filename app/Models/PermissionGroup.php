<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        
    ];

    protected array $translatableFields = [
        'name',
        'description'
    ];

    // Relations
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_group_permission');
    }

    public function permissionGroupPermissions()
    {
        return $this->hasMany(PermissionGroupPermission::class, 'permission_group_id');
    }

    // Other Methods

    public function remove()
    {
        $this->translations()->delete();
        $this->delete();
    }
}

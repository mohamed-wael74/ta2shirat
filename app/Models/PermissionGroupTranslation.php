<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroupTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_group_id',
        'locale',
        'name',
        'description'
    ];

    public function permissionGroup()
    {
        return $this->belongsTo(PermissionGroup::class);
    }
}

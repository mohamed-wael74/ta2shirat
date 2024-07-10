<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_group_permission');
    }

    public function permissionGroupPermissions()
    {
        return $this->hasMany(PermissionGroupPermission::class, 'permission_group_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PermissionGroupTranslation::class);
    }

    public function currentTranslation()
    {
        return $this->translations->where('locale', app()->getLocale())->first();
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->currentTranslation()->name ??
                $this->translations->where('locale', config('app.fallback_locale'))->first()->name,
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->currentTranslation()->description ??
                $this->translations->where('locale', config('app.fallback_locale'))->first()->description,
        );
    }

    // other methods
    public function remove()
    {
        $this->translations()->delete();
        $this->delete();
    }
}

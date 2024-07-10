<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use HasFactory;

    public $fillable = [];

    public function translations(): HasMany
    {
        return $this->hasMany(RoleTranslation::class);
    }

    public function currentTranslation(): Collection
    {
        return $this->translations->where('locale', app()->getLocale());
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->currentTranslation()->first()->name ??
                $this->translations->where('locale', config('app.fallback_locale'))->first()->name,
        );
    }

    protected function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->currentTranslation()->first()->description ??
                $this->translations->where('locale', config('app.fallback_locale'))->first()->description,
        );
    }

    public function isMainRole()
    {
        return $this->id === 1;
    }

    public function remove(): bool
    {
        if ($this->isMainRole()) {
            return false;
        }

        return DB::transaction(function () {
            $this->users->each->detachRolePermissions($this);
            $this->syncPermissions([]);
            $this->users()->sync([]);
            $this->translations()->delete();
            $this->delete();

            return true;
        });
    }


}

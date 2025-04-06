<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    use HasFactory, Translatable;

    public $fillable = [

    ];

    protected array $translatableFields = [
        'name',
        'description'
    ];

    // Other Methods

    public function isMainRole()
    {
        return $this->id == 1;
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

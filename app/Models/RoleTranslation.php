<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'locale',
        'name',
        'description'
    ];

    protected function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}

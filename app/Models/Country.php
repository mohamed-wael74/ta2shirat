<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory, Filterable, Searchable, Translatable;

    protected $fillable = [
        'code',
        'flag',
        'is_available'
    ];

    protected array $translatableFields = [
        'name'
    ];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    // Relations

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Scopes

    public function scopeAvailable($query, bool $is_available = true): Builder
    {
        return $query->where('is_available', $is_available);
    }
}

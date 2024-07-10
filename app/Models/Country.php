<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Country extends Model
{
    use HasFactory, Filterable, Searchable;

    protected $fillable = [
        'code',
        'flag',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean'
    ];

    protected $appends = [
        'name'
    ];

    public function scopeIsAvailable($query, bool $is_available = true): Builder
    {
        return $query->where('is_available', $is_available);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(CountryTranslation::class);
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
}

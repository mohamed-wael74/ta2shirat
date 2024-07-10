<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VisaType extends Model
{
    use HasFactory, Filterable, Searchable;

    protected $fillable = [

    ];

    public function translations(): HasMany
    {
        return $this->hasMany(VisaTypeTranslation::class);
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

    public function remove(): bool
    {
        $this->translations()->delete();
        $this->delete();

        return true;
    }
}

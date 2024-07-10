<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploymentType extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    public function translations(): HasMany
    {
        return $this->hasMany(EmploymentTypeTranslation::class);
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

    // Other methods
    public function remove()
    {
        $this->translations()->delete();
        $this->delete();
    }
}

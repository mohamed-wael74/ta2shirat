<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;

trait Translatable
{
    public function translations(): HasMany
    {
        return $this->hasMany($this->getTranslationModel());
    }

    public function translation($currentLocale = null)
    {
        return $this->translations->where('locale', ($currentLocale ?? app()->getLocale()))->first();
    }

    public function __get($key)
    {
        return in_array(needle: $key, haystack: $this->getTranslatableFields()) ? $this->getTranslatedAttribute($key) : parent::__get($key);
    }

    protected function getTranslatedAttribute($key)
    {
        $translation = $this->translations->where('locale', app()->getLocale())->first();

        return $translation ? $translation->$key : '';
    }

    protected function getTranslationModel(): string
    {
        return $this->translationModel ?? get_class($this) . 'Translation';
    }

    protected function getTranslatableFields(): array
    {
        return $this->translatableFields ?? [];
    }
}

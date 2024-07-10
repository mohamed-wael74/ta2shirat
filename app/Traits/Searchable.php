<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait Searchable
{
    public function scopeSearch($query, array $attributes, string $keyword = ''): void
    {
        foreach(Arr::wrap($attributes) as $attribute) {
            if ($attribute === 'name' && method_exists($this, 'translations')) {
                $query->whereHas('translations', function ($query) use ($attribute, $keyword) {
                    $query->where($attribute, 'like', "%{$keyword}%");
                });
            } else {
                $query->orWhere($attribute, 'like', "%{$keyword}%");
            }
        }
    }
}

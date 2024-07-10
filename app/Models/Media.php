<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'path',
        'type',
        'order',
        'size',
        'is_main'
    ];

    protected $casts = [
        'is_main' => 'boolean'
    ];

    public function scopeIsMain($query, bool $is_main = true): Builder
    {
        return $query->where('is_main', $is_main);
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}

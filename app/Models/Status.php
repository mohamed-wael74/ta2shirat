<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_type_id',
        'active_date_at_at',
    ];

    protected $casts = [
        'active_date_at' => 'datetime',
    ];

    ## Relations

    public function statusType(): BelongsTo
    {
        return $this->belongsTo(StatusType::class);
    }

    public function statusable(): MorphTo
    {
        return $this->morphTo();
    }

    ## Getters & Setters

    public function getIsActiveAttribute()
    {
        return !is_null($this->active_date_at);
    }
}
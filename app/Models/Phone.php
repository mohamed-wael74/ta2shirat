<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_code',
        'phone',
        'extension',
        'holder_name',
        'type'
    ];

    public function phonable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

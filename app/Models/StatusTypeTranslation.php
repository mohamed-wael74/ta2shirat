<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTypeTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'locale',
        'name',
    ];

    ## Relations

    public function statusType()
    {
        return $this->belongsTo(StatusType::class, 'status_type_id');
    }
}

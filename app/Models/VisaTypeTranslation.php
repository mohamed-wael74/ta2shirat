<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaTypeTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'visa_type_id',
        'locale',
        'name'
    ];

    public function visaType()
    {
        return $this->belongsTo(VisaType::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentTypeTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employment_type_id',
        'locale',
        'name'
    ];

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class);
    }
}

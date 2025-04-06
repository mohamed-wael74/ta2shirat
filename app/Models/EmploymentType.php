<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentType extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [

    ];

    protected array $translatableFields = [
        'name'
    ];

    // Other Methods

    public function remove()
    {
        $this->translations()->delete();
        $this->delete();
    }
}

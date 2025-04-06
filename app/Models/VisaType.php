<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Searchable;
use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisaType extends Model
{
    use HasFactory, Filterable, Searchable, Translatable;

    protected $fillable = [

    ];

    protected array $translatableFields = [
        'name'
    ];

    // Other Methods

    public function remove(): bool
    {
        $this->translations()->delete();
        $this->delete();

        return true;
    }
}

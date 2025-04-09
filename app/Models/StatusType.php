<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusType extends Model
{
    use HasFactory, Translatable;

    protected $fillable = [
        'type',
        'color',
    ];

    protected array $translatableFields = [
        'name',
    ];

    ## Relations

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }

    ## Other Methods

    public function nextAllowedStatusesNamesMap(): array
    {
        $statusMap = [
            'pending' => ['canceled', 'in_review'],
            'in_review' => ['canceled', 'rejected', 'accepted'],
            'accepted' => ['canceled', 'sold'],
        ];

        return $statusMap[$this->type] ?? [];
    }
}

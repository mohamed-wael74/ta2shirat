<?php

namespace App\Models;

use App\Traits\DealWithStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellingVisa extends Model
{
    use HasFactory, DealWithStatus;

    protected $fillable = [
        'user_id',
        'nationality_id',
        'destination_id',
        'visa_type_id',
        'employment_type_id',
        'provider_name',
        'contact_email',
        'required_qualifications',
        'message',
        'is_done',
    ];

    protected $casts = [
        'is_done' => 'boolean',
    ];

    ## Relations

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'nationality_id');
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'destination_id');
    }

    public function visaType(): BelongsTo
    {
        return $this->belongsTo(VisaType::class);
    }

    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(EmploymentType::class);
    }
}

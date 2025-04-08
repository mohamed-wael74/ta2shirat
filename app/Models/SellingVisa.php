<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SellingVisa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nationality_id',
        'destination_id',
        'visa_type_id',
        'employment_type_id',
        'provider_name',
        'contact_email',
        'required_notifications',
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

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable')->orderBy('active_date_at', 'asc');
    }

    public function currentStatus()
    {
        return $this->statuses()
            ->whereNotNull('active_date_at')
            ->orderBy('active_date_at', 'desc')
            ->first();
    }

    ## Other Methods
    
    public function activateStatus(int $statusTypeId): void
    {
        $this->statuses()->where('status_type_id', $statusTypeId)->update([
            'active_date_at_at' => now()
        ]);
    }
}

<?php

namespace App\Traits;

use App\Models\Status;
use App\Models\StatusType;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait DealWithStatus
{
    public function statuses(): MorphMany
    {
        return $this->morphMany(Status::class, 'statusable');
    }

    public function currentStatus()
    {
        return $this->statuses()
            ->whereNotNull('active_date_at')
            ->latest('active_date_at')
            ->first();
    }

    public function canUpdateStatus(string $statusType): bool
    {
        $currentStatus = $this->currentStatus();
        if (!$currentStatus) {
            return false;
        }

        $currentStatusType = $currentStatus->statusType;
        $allowedNextStatuses = $currentStatusType->nextAllowedStatusesNamesMap();

        return in_array($statusType, $allowedNextStatuses);
    }

    public function createStatuses(): void
    {
        $statusTypeIds = StatusType::pluck('id')->toArray();
        $statuses = [];

        foreach ($statusTypeIds as $statusTypeId) {
            $statuses[] = [
                'status_type_id' => $statusTypeId,
            ];
        }

        $this->statuses()->createMany($statuses);
    }

    public function activateStatus(int $statusTypeId): void
    {
        $this->statuses()
            ->where('status_type_id', $statusTypeId)
            ->update([
                'active_date_at' =>
                    now()
            ]);
    }
}
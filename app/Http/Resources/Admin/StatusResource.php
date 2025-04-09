<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'active' => $this->isActive,
            'active_date' => $this->active_date_at,
            'status_type' => new StatusTypeResource($this->statusType),
        ];
    }
}

<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class SellingVisaSimpleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'provider_name' => $this->provider_name,
            'contact_email' => $this->contact_email,
            'is_done' => $this->is_done,
            'created_at' => $this->created_at,
            'user' => new UserSimpleResource($this->user),
            'nationality' => new CountryResource($this->nationality),
            'destination' => new CountryResource($this->destination),
            'visa_type' => new VisaTypeResource($this->visaType),
            'employment_type' => new EmploymentTypeResource($this->employmentType),
            'current_status' => new StatusResource($this->currentStatus()),
            'statuses' => StatusResource::collection($this->statuses),
        ];
    }
}

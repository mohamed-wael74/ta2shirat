<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhoneResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country_code' => $this->country_code,
            'phone' => $this->phone,
            'extension' => $this->extension,
            'holder_name' => $this->holder_name,
            'type' => $this->type,
        ];
    }
}

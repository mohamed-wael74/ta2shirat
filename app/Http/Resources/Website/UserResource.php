<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\Admin\CountryResource;
use App\Http\Resources\PhoneResource;
use App\Http\Resources\MediaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'email_verified' => $this->email_verified_at,
            'phone_verified' => $this->phone_verified_at,
            'image' => MediaResource::make($this->main_medium),
            'phone' => PhoneResource::make($this->phone),
            'country' => CountryResource::make($this->country),
        ];
    }
}

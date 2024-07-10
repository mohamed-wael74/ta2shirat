<?php

namespace App\Http\Resources\Website;

use App\Http\Resources\Admin\CountryResource;
use App\Http\Resources\PhoneResource;
use App\Http\Resources\MediaResource;
use App\Http\Resources\Admin\RoleSimpleResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'middlename' => $this->middlename,
            'lastname' => $this->lastname,
            'phone' => PhoneResource::make($this->phone),
            'email' => $this->email,
            'country' => CountryResource::make($this->country),
            'birthdate' => $this->birthdate,
            'image' => MediaResource::make($this->main_medium),
            'email_verified' => $this->email_verified_at,
            'phone_verified' => $this->phone_verified_at,
        ];
    }
}

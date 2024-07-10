<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'path' => url(Storage::url($this->path)),
            'type' => $this->type,
            'order' => $this->order,
            'size' => $this->size,
            'main' => $this->is_main
        ];
    }
}

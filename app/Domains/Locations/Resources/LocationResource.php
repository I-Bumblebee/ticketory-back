<?php

namespace App\Domains\Locations\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}

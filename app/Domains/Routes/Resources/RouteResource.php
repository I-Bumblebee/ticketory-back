<?php

namespace App\Domains\Routes\Resources;

use App\Domains\Locations\Resources\LocationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RouteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_location_id' => $this->start_location_id,
            'start_location' => LocationResource::make($this->whenLoaded('startLocation')),
            'end_location_id' => $this->end_location_id,
            'end_location' => LocationResource::make($this->whenLoaded('endLocation')),
        ];
    }
}

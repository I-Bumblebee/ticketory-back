<?php

namespace App\Domains\Vehicles\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vehicle_number' => $this->vehicle_number,
            'type' => $this->type,
            'total_seats' => $this->total_seats,
            'seats' => SeatResource::collection($this->whenLoaded('seats')),
        ];
    }
}

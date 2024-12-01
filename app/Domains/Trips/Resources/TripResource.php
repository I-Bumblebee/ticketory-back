<?php

namespace App\Domains\Trips\Resources;

use App\Domains\Routes\Resources\RouteResource;
use App\Domains\Vehicles\Resources\VehicleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'route_id' => $this->route_id,
            'route' => RouteResource::make($this->whenLoaded('route')),
            'vehicle_id' => $this->vehicle_id,
            'vehicle' => VehicleResource::make($this->whenLoaded('vehicle')),
            'departure_time' => $this->departure_time,
            'arrival_time' => $this->arrival_time,
            'trip_duration_minutes' => $this->trip_duration_minutes,
            'seat_pricing' => $this->seat_pricing,
        ];
    }
}

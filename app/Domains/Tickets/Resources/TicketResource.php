<?php

namespace App\Domains\Tickets\Resources;

use App\Domains\Trips\Resources\TripResource;
use App\Domains\Users\Resources\UserResource;
use App\Domains\Vehicles\Resources\SeatResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'trip_id' => $this->trip_id,
            'trip' => TripResource::make($this->whenLoaded('trip')),
            'seat_id' => $this->seat_id,
            'seat' => SeatResource::make($this->whenLoaded('seat')),
            'price' => $this->price,
            'status' => $this->status,
        ];
    }
}

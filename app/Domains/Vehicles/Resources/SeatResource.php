<?php

namespace App\Domains\Vehicles\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'seat_identifier' => $this->seat_identifier,
            'class' => $this->class,
        ];
    }
}

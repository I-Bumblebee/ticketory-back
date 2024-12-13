<?php

namespace App\Domains\Trips\Observers;

use App\Domains\Tickets\Enums\TicketStatusEnum;
use App\Domains\Tickets\Models\Ticket;
use App\Domains\Trips\Models\Trip;
use App\Domains\Vehicles\Models\Seat;

class TripObserver
{
    public function created(Trip $trip): void
    {
        $seats = Seat::whereVehicleId($trip->vehicle_id)->get();

        foreach ($seats as $seat) {
            Ticket::firstOrCreate([
                'trip_id' => $trip->id,
                'seat_id' => $seat->id,
                'status' => TicketStatusEnum::Available,
            ]);
        }
    }
}


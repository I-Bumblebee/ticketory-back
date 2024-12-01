<?php

namespace App\Domains\Tickets\Observers;

use App\Domains\Tickets\Models\Ticket;
use App\Domains\Vehicles\Enums\VehicleSeatClassEnum;

class TicketObserver
{
    public function created(Ticket $ticket): void
    {
        // Map and set ticket price according to $ticket->trip->seat_prices
        /** @var array<VehicleSeatClassEnum, float|null> $seatPrices */
        $seatPrices = $ticket->trip->seat_pricing;
        $seat = $ticket->seat;

        $ticket->update([
            'price' => $seatPrices[$seat->class->value] ?? null,
        ]);
    }
}

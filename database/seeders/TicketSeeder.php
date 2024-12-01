<?php

namespace Database\Seeders;

use App\Domains\Tickets\Enums\TicketStatusEnum;
use App\Domains\Tickets\Models\Ticket;
use App\Domains\Trips\Models\Trip;
use App\Domains\Vehicles\Models\Seat;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $trips = Trip::all();

        foreach ($trips as $trip) {
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
}

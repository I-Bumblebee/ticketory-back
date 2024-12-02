<?php

namespace App\Domains\Trips\Actions;

use App\Domains\Trips\Models\Trip;
use App\Domains\Vehicles\Enums\VehicleSeatClassEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class BuyTicketsForTripAction
{
    use AsAction;

    public function rules(): array
    {
        return [
            'seat_class' => ['required', 'string', Rule::enum(VehicleSeatClassEnum::class)],
            'ticket_count' => ['required', 'numeric'],
        ];
    }

    public function afterValidator(Validator $validator, ActionRequest $request): void
    {
        if ($validator->failed()) {
            return;
        }

        // Count number of tickets user already has for that trip
        $trip = ($request->route('trip'));
        $ownedTripTickets = Auth::user()->tickets()->whereTripId($trip->id)->count();
        if ($ownedTripTickets + $request->validated('ticket_count') > 3) {
            $validator->messages()->add('message', 'You have bought too many tickets for this trip');

            return;
        }

        $totalAvailableTickets = $trip->tickets()
            ->available()
            ->seatClass(VehicleSeatClassEnum::from($request->validated('seat_class')))
            ->count();

        if ($totalAvailableTickets < $request->validated('ticket_count')) {
            $validator->messages()->add('message', 'Tickets have been sold out');

            return;
        }
    }

    public function handle(Trip $trip, ActionRequest $request): void
    {
        $availableTickets = $trip->tickets()
            ->available()
            ->seatClass(VehicleSeatClassEnum::from($request->validated('seat_class')))
            ->take($request->validated('ticket_count'))
            ->get();

        $availableTickets->each(fn ($ticket) => $ticket->book(Auth::user()));
    }
}

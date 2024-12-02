<?php

namespace App\Domains\Users\Actions;

use App\Domains\Tickets\Resources\TicketResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class GetUserTickets
{
    use AsAction;

    public function jsonResponse(Collection $tickets): AnonymousResourceCollection
    {
        return TicketResource::collection($tickets);
    }

    public function handle(): Collection
    {
        $tickets = Auth::user()->tickets;
        $tickets->load(['trip.route.startLocation', 'trip.route.endLocation', 'seat', 'trip.vehicle']);

        return $tickets;
    }
}

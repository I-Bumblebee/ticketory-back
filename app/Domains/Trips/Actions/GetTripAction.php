<?php

namespace App\Domains\Trips\Actions;

use App\Domains\Trips\Models\Trip;
use App\Domains\Trips\Resources\TripResource;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTripAction
{
    use AsAction;

    public function jsonResponse(Trip $trip): TripResource
    {
        return TripResource::make($trip);
    }

    public function handle(Trip $trip, ActionRequest $request): Trip
    {
        $trip->load(['vehicle', 'route.startLocation', 'route.endLocation']);

        return $trip;
    }
}

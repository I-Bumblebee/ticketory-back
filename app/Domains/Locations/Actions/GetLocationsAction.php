<?php

namespace App\Domains\Locations\Actions;

use App\Domains\Locations\Models\Location;
use App\Domains\Locations\Resources\LocationResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetLocationsAction
{
    use AsAction;

    /**
     * @param  Collection<Location>  $locations
     */
    public function jsonResponse(Collection $locations): AnonymousResourceCollection
    {
        return LocationResource::collection($locations);
    }

    /**
     * @return Collection<Location>
     */
    public function handle(): Collection
    {
        return Location::all();
    }
}

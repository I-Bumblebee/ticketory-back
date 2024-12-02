<?php

namespace App\Domains\Locations\Actions;

use App\Domains\Locations\Models\Location;
use App\Domains\Routes\Resources\RouteResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetLocationRoutesAction
{
    use AsAction;

    public function jsonResponse(Collection $routes): AnonymousResourceCollection
    {
        return RouteResource::collection($routes);
    }

    public function handle(Location $location): Collection
    {
        return $location->routes()->with(['endLocation', 'startLocation'])->get();
    }
}

<?php

namespace App\Domains\Routes\Actions;

use App\Domains\Routes\Models\Route;
use App\Domains\Trips\Models\Trip;
use App\Domains\Trips\Resources\TripResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class GetRouteTripsAction
{
    use AsAction;

    public function jsonResponse(Collection $trips): AnonymousResourceCollection
    {
        return TripResource::collection($trips);
    }

    public function handle(Route $route): Collection
    {
        return QueryBuilder::for(Trip::forRoute($route->id))
            ->allowedIncludes([
                'vehicle',
            ])
            ->allowedFilters([
                AllowedFilter::partial('date', 'departure_time'),
            ])
            ->get();
    }
}

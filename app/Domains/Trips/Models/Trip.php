<?php

namespace App\Domains\Trips\Models;

use App\Domains\Routes\Models\Route;
use App\Domains\Tickets\Models\Ticket;
use App\Domains\Trips\Observers\TripObserver;
use App\Domains\Vehicles\Models\Vehicle;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperTrip
 */
#[ObservedBy(TripObserver::class)]
class Trip extends Model
{
    protected $fillable = [
        'route_id',
        'vehicle_id',
        'departure_time',
        'trip_duration_minutes',
        'seat_pricing',
    ];

    protected function casts(): array
    {
        return [
            'departure_time' => 'datetime',
            'seat_pricing' => 'array',
        ];
    }

    protected function arrivalTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->departure_time->copy()->addMinutes($this->trip_duration_minutes)
        );
    }

    public function scopeForRoute(Builder $query, int $routeId): Builder
    {
        return $query->whereRouteId($routeId);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}

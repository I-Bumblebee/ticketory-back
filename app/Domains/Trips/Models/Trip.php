<?php

namespace App\Domains\Trips\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTrip
 */
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
}

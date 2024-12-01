<?php

namespace App\Domains\Vehicles\Models;

use App\Domains\Vehicles\Enums\VehicleSeatClassEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSeat
 */
class Seat extends Model
{
    protected $fillable = [
        'vehicle_id',
        'seat_identifier',
        'class',
    ];

    protected function casts(): array
    {
        return [
            'class' => VehicleSeatClassEnum::class,
        ];
    }
}

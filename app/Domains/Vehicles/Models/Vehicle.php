<?php

namespace App\Domains\Vehicles\Models;

use App\Domains\Vehicles\Enums\VehicleTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperVehicle
 */
class Vehicle extends Model
{
    protected $fillable = [
        'vehicle_number',
        'type',
        'total_seats',
    ];

    protected function casts(): array
    {
        return [
            'type' => VehicleTypeEnum::class,
        ];
    }

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}

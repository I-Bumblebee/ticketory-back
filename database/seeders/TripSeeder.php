<?php

namespace Database\Seeders;

use App\Domains\Routes\Models\Route;
use App\Domains\Trips\Models\Trip;
use App\Domains\Vehicles\Enums\VehicleSeatClassEnum;
use App\Domains\Vehicles\Enums\VehicleTypeEnum;
use App\Domains\Vehicles\Models\Vehicle;
use Illuminate\Database\Seeder;

class TripSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = Vehicle::all();

        $tripSchedules = [
            [
                'route_name' => 'Tbilisi Central Station -> Batumi International Bus Terminal',
                'vehicle_type' => 'bus',
                'departure_times' => [
                    '2024-07-01 08:00:00',
                    '2024-07-01 14:00:00',
                    '2024-07-01 20:00:00',
                ],
                'duration' => 480, // 8 hours
            ],
            [
                'route_name' => 'Tbilisi Central Station -> Kutaisi Central Station',
                'vehicle_type' => 'bus',
                'departure_times' => [
                    '2024-07-01 06:30:00',
                    '2024-07-01 12:30:00',
                    '2024-07-01 18:30:00',
                ],
                'duration' => 240, // 4 hours
            ],
            [
                'route_name' => 'Tbilisi Central Station -> Poti Harbor',
                'vehicle_type' => 'train',
                'departure_times' => [
                    '2024-07-01 09:00:00',
                    '2024-07-01 15:00:00',
                ],
                'duration' => 360, // 6 hours
            ],
            [
                'route_name' => 'Tbilisi Central Station -> Zugdidi Railway Station',
                'vehicle_type' => 'plane',
                'departure_times' => [
                    '2024-07-01 11:00:00',
                    '2024-07-01 17:00:00',
                ],
                'duration' => 120, // 2 hours
            ],
        ];

        foreach ($tripSchedules as $tripSchedule) {
            // Find the route
            $routeParts = explode(' -> ', $tripSchedule['route_name']);
            $route = Route::whereHas('startLocation', fn ($q) => $q->where('name', $routeParts[0]))
                ->whereHas('endLocation', fn ($q) => $q->where('name', $routeParts[1]))
                ->first();

            // Find a suitable vehicle
            $vehicle = $vehicles->first(fn ($v) => strtolower($v->type->value) === $tripSchedule['vehicle_type']
            );

            if (!$route || !$vehicle) {
                continue;
            }

            // Create trips for each departure time
            foreach ($tripSchedule['departure_times'] as $departureTime) {
                Trip::create([
                    'route_id' => $route->id,
                    'vehicle_id' => $vehicle->id,
                    'departure_time' => $departureTime,
                    'trip_duration_minutes' => $tripSchedule['duration'],
                    'seat_pricing' => $this->generateSeatPricing($vehicle->type),
                ]);
            }
        }
    }

    private function generateSeatPricing(VehicleTypeEnum $vehicleType): array
    {
        return match ($vehicleType) {
            VehicleTypeEnum::Bus => [
                VehicleSeatClassEnum::EconomyClass->value => 50.00,
                VehicleSeatClassEnum::PremiumEconomyClass->value => 75.00,
                VehicleSeatClassEnum::BusinessClass->value => null,
                VehicleSeatClassEnum::FirstClass->value => null,
                VehicleSeatClassEnum::VipClass->value => null,
                VehicleSeatClassEnum::SleeperClass->value => null,
            ],
            VehicleTypeEnum::Train => [
                VehicleSeatClassEnum::EconomyClass->value => 40.00,
                VehicleSeatClassEnum::PremiumEconomyClass->value => null,
                VehicleSeatClassEnum::BusinessClass->value => 80.00,
                VehicleSeatClassEnum::FirstClass->value => 120.00,
                VehicleSeatClassEnum::VipClass->value => null,
                VehicleSeatClassEnum::SleeperClass->value => null,
            ],
            VehicleTypeEnum::Plane => [
                VehicleSeatClassEnum::EconomyClass->value => 150.00,
                VehicleSeatClassEnum::PremiumEconomyClass->value => null,
                VehicleSeatClassEnum::BusinessClass->value => 300.00,
                VehicleSeatClassEnum::FirstClass->value => 500.00,
                VehicleSeatClassEnum::VipClass->value => null,
                VehicleSeatClassEnum::SleeperClass->value => null,
            ],
        };
    }
}

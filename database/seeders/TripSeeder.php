<?php

namespace Database\Seeders;

use App\Domains\Routes\Models\Route;
use App\Domains\Trips\Models\Trip;
use App\Domains\Vehicles\Enums\VehicleSeatClassEnum;
use App\Domains\Vehicles\Enums\VehicleTypeEnum;
use App\Domains\Vehicles\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Random\RandomException;

use function random_int;

class TripSeeder extends Seeder
{
    public function run(?Carbon $departureDate = null): void
    {
        $vehicles = Vehicle::all();

        $tripSchedules = [
            [
                'route_name' => 'Tbilisi Central Station -> Batumi International Bus Terminal',
                'vehicle_type' => 'bus',
                'departure_hours' => [8, 14, 20],
                'duration' => 480,
            ],
            [
                'route_name' => 'Tbilisi Central Station -> Kutaisi Central Station',
                'vehicle_type' => 'bus',
                'departure_hours' => [6.5, 12.5, 18.5],
                'duration' => 240,
            ],
            [
                'route_name' => 'Tbilisi Central Station -> Poti Harbor',
                'vehicle_type' => 'train',
                'departure_hours' => [9, 15],
                'duration' => 360,
            ],
            [
                'route_name' => 'Tbilisi Central Station -> Zugdidi Railway Station',
                'vehicle_type' => 'plane',
                'departure_hours' => [11, 17],
                'duration' => 120,
            ],
        ];

        $seedDate = $departureDate ?? Carbon::create(2024, 12, 5);
        $this->seedTrips($tripSchedules, $vehicles, $seedDate);
    }

    private function seedTrips(array $tripSchedules, $vehicles, Carbon $date): void
    {
        foreach ($tripSchedules as $tripSchedule) {
            $route = $this->findRoute($tripSchedule['route_name']);
            $vehicle = $this->findVehicle($vehicles, $tripSchedule['vehicle_type']);

            if (!$route || !$vehicle) {
                continue;
            }

            foreach ($tripSchedule['departure_hours'] as $hour) {
                $departureTime = $this->generateDepartureTime($date, $hour);
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

    private function findRoute(string $routeName): ?Route
    {
        $routeParts = explode(' -> ', $routeName);

        return Route::whereHas('startLocation', fn ($q) => $q->where('name', $routeParts[0]))
            ->whereHas('endLocation', fn ($q) => $q->where('name', $routeParts[1]))
            ->first();
    }

    private function findVehicle($vehicles, string $vehicleType): ?Vehicle
    {
        return $vehicles->first(fn ($v) => strtolower($v->type->value) === $vehicleType);
    }

    /**
     * @throws RandomException
     */
    private function generateDepartureTime(Carbon $date, float $hour): Carbon
    {
        $hours = floor($hour);
        $minutes = ($hour - $hours) * 60;

        return $date->copy()->setTime($hours, $minutes)->addMinutes(random_int(0, 360));
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


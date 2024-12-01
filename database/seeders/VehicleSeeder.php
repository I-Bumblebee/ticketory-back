<?php

namespace Database\Seeders;

use App\Domains\Vehicles\Enums\VehicleSeatClassEnum;
use App\Domains\Vehicles\Enums\VehicleTypeEnum;
use App\Domains\Vehicles\Models\Seat;
use App\Domains\Vehicles\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        // Bus
        $bus1 = Vehicle::create([
            'vehicle_number' => 'GE-BUS-001',
            'type' => VehicleTypeEnum::Bus,
            'total_seats' => 52,
        ]);
        $this->seedSeats($bus1, [
            VehicleSeatClassEnum::EconomyClass->value => 40,
            VehicleSeatClassEnum::PremiumEconomyClass->value => 12,
        ]);

        $bus2 = Vehicle::create([
            'vehicle_number' => 'GE-BUS-002',
            'type' => VehicleTypeEnum::Bus,
            'total_seats' => 48,
        ]);
        $this->seedSeats($bus2, [
            VehicleSeatClassEnum::EconomyClass->value => 36,
            VehicleSeatClassEnum::PremiumEconomyClass->value => 12,
        ]);

        // Train
        $train1 = Vehicle::create([
            'vehicle_number' => 'GE-TRAIN-001',
            'type' => VehicleTypeEnum::Train,
            'total_seats' => 120,
        ]);
        $this->seedSeats($train1, [
            VehicleSeatClassEnum::EconomyClass->value => 80,
            VehicleSeatClassEnum::BusinessClass->value => 24,
            VehicleSeatClassEnum::FirstClass->value => 16,
        ]);

        // Plane (with limited seats)
        $plane1 = Vehicle::create([
            'vehicle_number' => 'GE-PLANE-001',
            'type' => VehicleTypeEnum::Plane,
            'total_seats' => 30,
        ]);
        $this->seedSeats($plane1, [
            VehicleSeatClassEnum::EconomyClass->value => 20,
            VehicleSeatClassEnum::BusinessClass->value => 8,
            VehicleSeatClassEnum::FirstClass->value => 2,
        ]);
    }

    public function seedSeats(Vehicle $vehicle, array $seatClassDistribution): void
    {
        foreach ($seatClassDistribution as $class => $count) {
            for ($i = 1; $i <= $count; $i++) {
                Seat::create([
                    'vehicle_id' => $vehicle->id,
                    'seat_identifier' => $this->generateSeatIdentifier($vehicle->type, $i, $class),
                    'class' => $class,
                ]);
            }
        }
    }

    private function generateSeatIdentifier(VehicleTypeEnum $type, int $seatNumber, string $class): string
    {
        $classPrefix = match ($class) {
            VehicleSeatClassEnum::EconomyClass->value => 'E',
            VehicleSeatClassEnum::PremiumEconomyClass->value => 'P',
            VehicleSeatClassEnum::BusinessClass->value => 'B',
            VehicleSeatClassEnum::FirstClass->value => 'F',
            VehicleSeatClassEnum::VipClass->value => 'V',
            VehicleSeatClassEnum::SleeperClass->value => 'S',
            default => 'X',
        };

        return match ($type) {
            VehicleTypeEnum::Plane => $classPrefix.chr(64 + ceil($seatNumber / 6)).($seatNumber % 6 ?: 6),
            VehicleTypeEnum::Bus => $classPrefix.'S'.str_pad($seatNumber, 2, '0', STR_PAD_LEFT),
            VehicleTypeEnum::Train => $classPrefix.'T'.str_pad($seatNumber, 3, '0', STR_PAD_LEFT),
        };
    }
}

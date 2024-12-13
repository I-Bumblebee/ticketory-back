<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->callOnce([
            LocationSeeder::class,
            RouteSeeder::class,
            VehicleSeeder::class,
            TripSeeder::class,
        ]);
    }
}

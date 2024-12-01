<?php

namespace Database\Seeders;

use App\Domains\Locations\Models\Location;
use App\Domains\Routes\Models\Route;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    public function run(): void
    {
        $locations = Location::all();

        $routeConnections = [
            ['Tbilisi Central Station', 'Batumi International Bus Terminal'],
            ['Tbilisi Central Station', 'Kutaisi Central Station'],
            ['Tbilisi Central Station', 'Poti Harbor'],
            ['Tbilisi Central Station', 'Rustavi Bus Terminal'],
            ['Tbilisi Central Station', 'Zugdidi Railway Station'],
            ['Tbilisi Central Station', 'Gori Bus Station'],
            ['Tbilisi Central Station', 'Telavi Central Square'],
            ['Tbilisi Central Station', 'Akhaltsikhe Bus Terminal'],
            ['Tbilisi Central Station', 'Khashuri Junction'],
            ['Batumi International Bus Terminal', 'Kutaisi Central Station'],
            ['Batumi International Bus Terminal', 'Poti Harbor'],
            ['Kutaisi Central Station', 'Zugdidi Railway Station'],
            ['Poti Harbor', 'Zugdidi Railway Station'],
            ['Gori Bus Station', 'Khashuri Junction'],
            ['Akhaltsikhe Bus Terminal', 'Khashuri Junction'],
            ['Rustavi Bus Terminal', 'Gori Bus Station'],
            ['Telavi Central Square', 'Gori Bus Station'],
        ];

        foreach ($routeConnections as $connection) {
            $startLocation = $locations->firstWhere('name', $connection[0]);
            $endLocation = $locations->firstWhere('name', $connection[1]);

            if ($startLocation && $endLocation) {
                Route::firstOrCreate([
                    'start_location_id' => $startLocation->id,
                    'end_location_id' => $endLocation->id,
                ]);

                Route::firstOrCreate([
                    'start_location_id' => $endLocation->id,
                    'end_location_id' => $startLocation->id,
                ]);
            }
        }
    }
}

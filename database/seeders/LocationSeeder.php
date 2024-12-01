<?php

namespace Database\Seeders;

use App\Domains\Locations\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Tbilisi Central Station',
                'city' => 'Tbilisi',
                'country' => 'Georgia',
                'latitude' => 41.693611,
                'longitude' => 41.693611,
            ],
            [
                'name' => 'Batumi International Bus Terminal',
                'city' => 'Batumi',
                'country' => 'Georgia',
                'latitude' => 41.640278,
                'longitude' => 41.639167,
            ],
            [
                'name' => 'Kutaisi Central Station',
                'city' => 'Kutaisi',
                'country' => 'Georgia',
                'latitude' => 42.265278,
                'longitude' => 42.695833,
            ],
            [
                'name' => 'Poti Harbor',
                'city' => 'Poti',
                'country' => 'Georgia',
                'latitude' => 42.146944,
                'longitude' => 41.675833,
            ],
            [
                'name' => 'Rustavi Bus Terminal',
                'city' => 'Rustavi',
                'country' => 'Georgia',
                'latitude' => 41.538333,
                'longitude' => 44.998056,
            ],
            [
                'name' => 'Zugdidi Railway Station',
                'city' => 'Zugdidi',
                'country' => 'Georgia',
                'latitude' => 42.500556,
                'longitude' => 41.864167,
            ],
            [
                'name' => 'Gori Bus Station',
                'city' => 'Gori',
                'country' => 'Georgia',
                'latitude' => 41.983333,
                'longitude' => 44.116667,
            ],
            [
                'name' => 'Telavi Central Square',
                'city' => 'Telavi',
                'country' => 'Georgia',
                'latitude' => 41.911389,
                'longitude' => 45.480833,
            ],
            [
                'name' => 'Akhaltsikhe Bus Terminal',
                'city' => 'Akhaltsikhe',
                'country' => 'Georgia',
                'latitude' => 41.640278,
                'longitude' => 42.500556,
            ],
            [
                'name' => 'Khashuri Junction',
                'city' => 'Khashuri',
                'country' => 'Georgia',
                'latitude' => 41.977222,
                'longitude' => 43.597778,
            ],
        ];

        foreach ($locations as $locationData) {
            Location::firstOrCreate(
                ['name' => $locationData['name']],
                $locationData,
            );
        }
    }
}

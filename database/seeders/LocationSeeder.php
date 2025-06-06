<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = ['New York', 'California', 'Miami', 'Texas', 'Oregon'];

        foreach ($locations as $name) {
            Location::create(['name' => $name]);
        }
    }
}

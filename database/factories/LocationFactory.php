<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $locations = ['New York', 'California', 'Miami', 'Texas', 'Oregon'];

        return [
            'name' => array_rand(array_keys($locations)),
        ];
    }
}

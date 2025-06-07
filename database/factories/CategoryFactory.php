<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = ['IT', 'Design', 'Marketing', 'Sales', 'Management'];

        return [
            'name' => array_rand(array_keys($categories)),
        ];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['IT', 'Design', 'Marketing', 'Sales', 'Management'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}

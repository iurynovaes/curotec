<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\JobType;
use App\Enums\ExperienceLevel;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition(): array
    {
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();
        $location = Location::inRandomOrder()->first() ?? Location::factory()->create();

        $randomSalary = $this->faker->numberBetween(1, 5) * 1000;
        $salaryRange = '$ ' . $randomSalary . ' - $ ' . ($randomSalary + 1000);

        return [
            'title' => ucwords($category->name) . ' Opportunity ' . $this->faker->unique()->numberBetween(1, 999),
            'description' => "Description of the opportunity that takes place in {$location->name}.",
            'salary_range' => $salaryRange,
            'type' => $this->faker->randomElement(JobType::values()),
            'experience_level' => $this->faker->randomElement(ExperienceLevel::values()),
            'category_id' => $category->id,
            'location_id' => $location->id,
            'active' => $this->faker->boolean(),
            'remote' => $this->faker->boolean(),
        ];
    }
}

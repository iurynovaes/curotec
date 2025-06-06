<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Category;
use App\Models\Location;
use App\Enums\JobType;
use App\Enums\ExperienceLevel;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $locations = Location::all();
        $jobTypes = JobType::values();
        $experienceLevels = ExperienceLevel::values();
        $randomSalary = array_rand([1,2,3,4,5]) * 1000;
        $randomSalaryMax = $randomSalary + 1000;
        $salaryRange = "$ $randomSalary - $ $randomSalaryMax";

        foreach (range(1, 30) as $i) {

            $randomCategory = $categories->random();
            $randomLocation = $locations->random();
            $title = ucwords($randomCategory->name). ' Opportunity ' . $i;
            $description = "Description of the $title that takes place in $randomLocation->name.";

            Job::create([
                'title' => $title,
                'description' => $description,
                'salary_range' => $salaryRange,
                'type' => $jobTypes[array_rand(array_keys($jobTypes))],
                'experience_level' => $experienceLevels[array_rand(array_keys($experienceLevels))],
                'category_id' => $randomCategory->id,
                'location_id' => $randomLocation->id,
                'active' => $i % 2 == 0,
                'remote' => $i % 2 == 0,
            ]);
        }
    }
}

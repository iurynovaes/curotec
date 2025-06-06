<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\JobApplication;
use Illuminate\Database\Seeder;
use App\Enums\ExperienceLevel;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $jobs = Job::all();
        $experienceLevels = ExperienceLevel::values();

        foreach ($jobs as $job) {
            
            for ($i = 0; $i < rand(1, 5); $i++) {

                JobApplication::create([
                    'job_id' => $job->id,
                    'user_id' => User::where('id', '<>', 1)->inRandomOrder()->value('id'),
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'last_position' => $faker->jobTitle,
                    'experience_years' => rand(0, 15),
                    'experience_level' => $experienceLevels[array_rand(array_keys($experienceLevels))],
                    'resume_path' => 'resumes/sample.pdf',
                    'cover_letter_path' => rand(0, 1) ? 'cover_letters/sample.pdf' : null,
                ]);
            }
        }
    }
}

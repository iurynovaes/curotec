<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Repositories\JobApplicationRepository;
use App\Services\CreateJobApplicationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class JobApplicationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CreateJobApplicationService $service;
    protected int $user_id;
    protected int $job_id;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $repository = new JobApplicationRepository();
        $this->service = new CreateJobApplicationService($repository);

        $user = User::factory()->create();
        $job = Job::factory()->create();

        $this->user_id = $user->id;
        $this->job_id = $job->id;
    }

    public function test_it_stores_application_and_files_correctly(): void
    {
        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '(123) 456-7890',
            'last_position' => 'Designer',
            'user_id' => $this->user_id,
            'job_id' => $this->job_id,
            'experience_years' => 5,
            'experience_level' => 'senior',
            'resume' => UploadedFile::fake()->create('resume.pdf', 500),
            'cover_letter' => UploadedFile::fake()->create('letter.pdf', 200),
        ];

        $this->service->handle($data);

        $app = JobApplication::first();

        $this->assertNotNull($app);
        $this->assertEquals('Jane Doe', $app->name);
        $this->assertTrue(Storage::disk('public')->exists($app->resume_path));
        $this->assertTrue(Storage::disk('public')->exists($app->cover_letter_path));
    }
}

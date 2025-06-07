<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreJobApplicationRequest;

class JobApplicationValidationTest extends TestCase
{
    protected array $rules;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rules = (new StoreJobApplicationRequest())->rules();
    }

    public function test_it_fails_when_required_fields_are_missing(): void
    {
        $data = [];
        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->fails());
        $this->assertEqualsCanonicalizing([
            'name',
            'email',
            'phone',
            'user_id',
            'job_id',
            'last_position',
            'experience_years',
            'experience_level',
            'resume',
        ], $validator->errors()->keys());
    }

    public function test_it_fails_on_invalid_email_and_resume(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'invalid-email',
            'phone' => '123 2342 2344',
            'last_position' => 'Dev',
            'user_id' => 1,
            'job_id' => 1,
            'experience_years' => 3,
            'experience_level' => 'mid',
            'resume' => UploadedFile::fake()->create('file.txt', 100),
        ];

        $validator = Validator::make($data, $this->rules);

        $this->assertTrue($validator->fails());
        $this->assertTrue($validator->errors()->has('email'));
        $this->assertTrue($validator->errors()->has('resume'));
    }
}

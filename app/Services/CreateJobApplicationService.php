<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Repositories\JobApplicationRepository;
use Illuminate\Http\UploadedFile;

class CreateJobApplicationService
{
    public function __construct(protected JobApplicationRepository $repository) {}

    public function handle(array $data): JobApplication
    {
        $resumePath = $this->storeFile($data['resume']);
        $coverLetterPath = $this->storeFile($data['cover_letter'] ?? null);
        
        unset($data['resume']);
        unset($data['cover_letter']);

        $data['resume_path'] = $resumePath;
        $data['cover_letter_path'] = $coverLetterPath;

        return $this->repository->create($data);
    }

    private function storeFile(?UploadedFile $file): ?string
    {
        return $file ? $file->store('applications', 'public') : null;
    }
}
<?php

namespace App\Repositories;

use App\Models\JobApplication;

class JobApplicationRepository
{
    public function create(array $data): JobApplication
    {
        return JobApplication::create($data);
    }
}
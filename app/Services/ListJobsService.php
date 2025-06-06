<?php

namespace App\Services;

use App\Repositories\JobRepository;

class ListJobsService
{
    public function __construct(protected JobRepository $repository) {}

    public function handle(array $filters)
    {
        return $this->repository->searchWithFilters($filters);
    }
}
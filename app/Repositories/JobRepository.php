<?php

namespace App\Repositories;

use App\Models\Job;

class JobRepository
{
    const ITEMS_PER_PAGE = 9;

    public function searchWithFilters(array $filters)
    {
        $active = isset($filters['active']) ? (bool) $filters['active'] : null;
        $remote = isset($filters['remote']) ? (bool) $filters['remote'] : null;
        
        return Job::with(['category', 'location'])
            ->when($filters['title'] ?? null, fn($q, $title) => $q->where('title', 'like', '%'.$title.'%'))
            ->when($filters['type'] ?? null, fn($q, $type) => $q->where('type', $type))
            ->when($filters['experience_level'] ?? null, fn($q, $level) => $q->where('experience_level', $level))
            ->when(isset($active), fn($q) => $q->where('active', $active))
            ->when(isset($remote), fn($q) => $q->where('remote', $remote))
            ->when($filters['category_id'] ?? null, fn($q, $cat) => $q->where('category_id', $cat))
            ->when($filters['location_id'] ?? null, fn($q, $loc) => $q->where('location_id', $loc))
            ->latest()
            ->paginate(self::ITEMS_PER_PAGE)
            ->appends($filters);
    }
}
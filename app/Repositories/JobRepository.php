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

        $orderBy = $filters['order_by'] ?? 'created_at_desc';

        switch ($orderBy) {
            case 'created_at_desc':
                $orderByColumn = 'jobs.created_at';
                $orderByDir = 'desc';
                break;
            case 'title_asc':
                $orderByColumn = 'jobs.title';
                $orderByDir = 'asc';
                break;
            case 'title_desc':
                $orderByColumn = 'jobs.title';
                $orderByDir = 'desc';
                break;
            default:
                $orderByColumn = 'jobs.created_at';
                $orderByDir = 'asc';
        }
        
        return Job::with(['category', 'location'])
            ->when($filters['title'] ?? null, fn($q, $title) => $q->where('title', 'like', '%'.$title.'%'))
            ->when($filters['type'] ?? null, fn($q, $type) => $q->where('type', $type))
            ->when($filters['experience_level'] ?? null, fn($q, $level) => $q->where('experience_level', $level))
            ->when(isset($active), fn($q) => $q->where('active', $active))
            ->when(isset($remote), fn($q) => $q->where('remote', $remote))
            ->when($filters['category_id'] ?? null, fn($q, $cat) => $q->where('category_id', $cat))
            ->when($filters['location_id'] ?? null, fn($q, $loc) => $q->where('location_id', $loc))
            ->orderBy($orderByColumn, $orderByDir)
            ->paginate(self::ITEMS_PER_PAGE)
            ->appends($filters);
    }
}
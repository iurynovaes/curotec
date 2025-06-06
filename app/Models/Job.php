<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ExperienceLevel;
use App\Enums\JobType;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'location_id',
        'type',
        'experience_level',
        'salary_range',
        'active',
        'remote'
    ];

    protected $casts = [
        'experience_level' => ExperienceLevel::class,
        'type' => JobType::class,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}

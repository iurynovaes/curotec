<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ExperienceLevel;
use App\Enums\JobType;
use App\Models\JobApplication;

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

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}

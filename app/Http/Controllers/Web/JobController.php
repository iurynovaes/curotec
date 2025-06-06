<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Services\ListJobsService;
use App\Models\Category;
use App\Models\Location;
use App\Enums\JobType;
use App\Enums\ExperienceLevel;

class JobController extends Controller
{
    public function __construct(protected ListJobsService $service) {}

    public function index(Request $request)
    {
        $categories = Category::all();
        $locations = Location::all();
        $jobTypes = JobType::cases();
        $experienceLevels = ExperienceLevel::cases();
        
        return view('jobs.index', compact('categories', 'locations', 'jobTypes', 'experienceLevels'));
    }
}

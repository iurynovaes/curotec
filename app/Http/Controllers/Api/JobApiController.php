<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Services\ListJobsService;

class JobApiController extends Controller
{
    public function __construct(protected ListJobsService $service) {}

    public function list(Request $request)
    {
        $jobs = $this->service->list($request->all());
        
        return JobResource::collection($jobs);
    }
}

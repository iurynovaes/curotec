<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobResource;
use App\Services\ListJobsService;
use App\Http\Requests\FilterJobsRequest;

class JobApiController extends Controller
{
    public function __construct(protected ListJobsService $service) {}

    public function list(FilterJobsRequest $request)
    {
        try {

            $filters = $request->validated();

            $jobs = $this->service->handle($filters);
        
            return JobResource::collection($jobs);

        } catch (Throwable $th) {

            Log::error($th->getMessage());

            return response()->json([
                'message' => 'Internal error',
                'error' => $th->getMessage()
            ], 500);
        }
        
    }
}

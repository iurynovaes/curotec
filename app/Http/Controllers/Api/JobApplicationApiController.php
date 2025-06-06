<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Services\CreateJobApplicationService;
use App\Http\Requests\StoreJobApplicationRequest;

class JobApplicationApiController extends Controller
{
    public function __construct(protected CreateJobApplicationService $service) {}

    public function store(StoreJobApplicationRequest $request)
    {
        try {

            $this->service->handle($request->validated());

            return response()->json([
                'message' => 'Your application has been submitted!'
            ], 201);

        } catch (Throwable $th) {

            Log::error($th->getMessage());

            return response()->json([
                'message' => 'Internal error',
                'error' => $th->getMessage()
            ], 500);
        }
    }

}

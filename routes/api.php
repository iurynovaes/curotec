<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\Api\JobApplicationApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['global_api_token'])->group(function () {

    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobApiController::class, 'list']);
        Route::post('/{job_id}/apply', [JobApplicationApiController::class, 'store']);
    });
});

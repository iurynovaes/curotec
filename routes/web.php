<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\JobController;
use App\Http\Controllers\Auth\LoginWebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [LoginWebController::class, 'show'])->name('login');
Route::post('/login', [LoginWebController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginWebController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('home');
    });

    Route::get('/jobs', [JobController::class, 'index'])->name('home');
});

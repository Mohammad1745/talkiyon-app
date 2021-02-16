<?php

use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\TimelineController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Profile
Route::prefix('profile')->name('profile')->group(function () {
    Route::get('/helpers', [ProfileController::class, 'helpers'])->name('.helpers');
    Route::get('/info', [ProfileController::class, 'info'])->name('.info');
    Route::post('/save-image', [ProfileController::class, 'saveImage'])->name('.saveImage');
});
//Talk
Route::prefix('talk')->name('talk')->group(function () {
    Route::get('/helpers', [TimelineController::class, 'helpers'])->name('.helpers');
    Route::post('/present', [TimelineController::class, 'present'])->name('.present');
    Route::get('/index', [TimelineController::class, 'index'])->name('.index');
    Route::get('/read', [TimelineController::class, 'read'])->name('.read');
    Route::post('/update', [TimelineController::class, 'update'])->name('.update');
    Route::get('/delete', [TimelineController::class, 'delete'])->name('.delete');
});

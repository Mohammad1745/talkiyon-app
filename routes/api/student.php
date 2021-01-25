<?php

use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\TalkController;
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
    Route::get('/info', [ProfileController::class, 'info'])->name('info');
    Route::post('/save-image', [ProfileController::class, 'saveImage'])->name('saveImage');
});
//Talk
Route::prefix('talk')->name('talk')->group(function () {
    Route::post('/release', [TalkController::class, 'release'])->name('release');
});

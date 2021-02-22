<?php

use App\Http\Controllers\Api\Student\Profile\ConnectionController;
use App\Http\Controllers\Api\Student\Profile\InformationController;
use App\Http\Controllers\Api\Student\Timeline\TalkController;
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
    Route::get('/helpers', [InformationController::class, 'helpers'])->name('.helpers');
    Route::get('/info', [InformationController::class, 'info'])->name('.info');
    Route::post('/save-image', [InformationController::class, 'saveImage'])->name('.saveImage');
    Route::post('/save-about', [InformationController::class, 'saveAbout'])->name('.saveAbout');

    Route::prefix('connection')->name('.connection')->group( function () {
        Route::get('/request', [ConnectionController::class, 'request'])->name('.request');
        Route::get('/index', [ConnectionController::class, 'index'])->name('.index');
        Route::post('/create', [ConnectionController::class, 'create'])->name('.create');
        Route::get('/delete', [ConnectionController::class, 'delete'])->name('.delete');
    });
});
//Timeline
Route::prefix('talk')->name('talk')->group(function () {
    Route::get('/helpers', [TalkController::class, 'helpers'])->name('.helpers');
    Route::post('/present', [TalkController::class, 'present'])->name('.present');
    Route::get('/index', [TalkController::class, 'index'])->name('.index');
    Route::get('/read', [TalkController::class, 'read'])->name('.read');
    Route::post('/update', [TalkController::class, 'update'])->name('.update');
    Route::get('/delete', [TalkController::class, 'delete'])->name('.delete');
});

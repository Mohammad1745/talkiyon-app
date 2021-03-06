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
    //Connection
    Route::prefix('/connection')->name('.connection')->group( function () {
        Route::get('/suggestions', [ConnectionController::class, 'suggestions'])->name('.suggestions');
        Route::get('/sent-requests', [ConnectionController::class, 'sentRequests'])->name('.sentRequests');
        Route::get('/received-requests', [ConnectionController::class, 'receivedRequests'])->name('.receivedRequests');
        Route::get('/connections', [ConnectionController::class, 'connections'])->name('.connections');
        Route::post('/send-request', [ConnectionController::class, 'sendRequest'])->name('.sendRequest');
        Route::post('/accept-request', [ConnectionController::class, 'acceptRequest'])->name('.acceptRequest');
        Route::get('/delete', [ConnectionController::class, 'delete'])->name('.delete');
    });
});
//Timeline
Route::prefix('talk')->name('talk')->group(function () {
    Route::get('/helpers', [TalkController::class, 'helpers'])->name('.helpers');
    Route::post('/share', [TalkController::class, 'share'])->name('.share');
    Route::post('/present', [TalkController::class, 'present'])->name('.present');
    Route::get('/index', [TalkController::class, 'index'])->name('.index');
    Route::get('/read', [TalkController::class, 'read'])->name('.read');
    Route::post('/update', [TalkController::class, 'update'])->name('.update');
    Route::get('/delete', [TalkController::class, 'delete'])->name('.delete');

    Route::get('/clap', [TalkController::class, 'clap'])->name('.clap');
    Route::get('/boo', [TalkController::class, 'boo'])->name('.boo');
    Route::post('/respond', [TalkController::class, 'respond'])->name('.respond');
    Route::post('/reply-to-response', [TalkController::class, 'replyToResponse'])->name('.replyToResponse');
    Route::post('/update-response', [TalkController::class, 'updateResponse'])->name('.updateResponse');
    Route::get('/delete-response', [TalkController::class, 'deleteResponse'])->name('.deleteResponse');
    Route::get('/clap-to-response', [TalkController::class, 'clapToResponse'])->name('.clapToResponse');
    Route::get('/boo-to-response', [TalkController::class, 'booToResponse'])->name('.booToResponse');
});

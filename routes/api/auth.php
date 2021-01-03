<?php

use App\Http\Controllers\Api\AuthController;
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

Route::post('/signup', [AuthController::class, 'signup'])->name('api.signup');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');
Route::middleware('auth:api')->group(function () {
    Route::get('/resend-email-verification-code', [AuthController::class, 'resendEmailVerificationCode'])->name('api.resendEmailVerificationCode');
    Route::get('/email-verification', [AuthController::class, 'emailVerification'])->name('api.emailVerification');
});

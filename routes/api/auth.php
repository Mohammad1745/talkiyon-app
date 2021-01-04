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
Route::post('/send-reset-password-code', [AuthController::class, 'sendResetPasswordCode'])->name('api.sendResetPasswordCode');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('api.resetPassword');
Route::middleware('auth:api')->group(function () {
    Route::get('/resend-email-verification-code', [AuthController::class, 'resendEmailVerificationCode'])->name('api.resendEmailVerificationCode');
    Route::post('/email-verification', [AuthController::class, 'emailVerification'])->name('api.emailVerification');
    Route::get('/logout', [AuthController::class, 'logout'])->name('api.logout');
});

<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/send-reset-password-code', [AuthController::class, 'sendResetPasswordCode'])->name('sendResetPasswordCode');
Route::post('/send-reset-password-code-process', [AuthController::class, 'sendResetPasswordCodeProcess'])->name('sendResetPasswordCodeProcess');
Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');
Route::post('/reset-password-process', [AuthController::class, 'resetPasswordProcess'])->name('resetPasswordProcess');
Route::get('/dummy', [AuthController::class, 'dummy'])->name('dummy');
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

<?php

use App\Http\Controllers\Web\Admin\DashboardController;
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
//Dashboard
Route::prefix('dashboard')->name('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('');
    Route::get('/content', [DashboardController::class, 'content'])->name('.content');
});

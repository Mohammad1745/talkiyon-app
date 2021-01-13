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
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/dashboard-content', [DashboardController::class, 'content'])->name('admin.dashboard.content');

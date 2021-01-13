<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/delete-user-from-table', function (Request $request) {
    try {
        \App\Models\User::where('role', '!=', ADMIN_ROLE)->where('phone', $request->phone)->delete();
        return [
            'success' => true,
            'message' => 'User has been deleted'
        ];
    } catch (Exception $exception) {
        return [
            'success' => true,
            'message' => $exception->getMessage()
        ];
    }
});

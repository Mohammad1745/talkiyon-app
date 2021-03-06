<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

//Dev Purpose API
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json(['success' => true, 'message' => 'Authorized']);
    });
});
Route::post('/delete-user-from-table', function (Request $request) {
    try {
        if (!$request->phone){
            return [
                'success' => false,
                'message' => 'Phone field is required'
            ];
        }
        $user = \App\Models\User::where('role', '!=', ADMIN_ROLE)->where('phone', $request->phone)->first();
        if (!$user) {
            return [
                'success' => false,
                'message' => 'Phone does not exist'
            ];
        }
        $user->delete();
        return [
            'success' => true,
            'message' => 'User has been deleted'
        ];
    } catch (Exception $exception) {
        return [
            'success' => false,
            'message' => $exception->getMessage()
        ];
    }
});

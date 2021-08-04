<?php

use Illuminate\Http\Request;
use Kaban\General\Api\V1\AuthController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'v1',
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/sanctum-me', [AuthController::class, 'me']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    dd(123);
    return $request->user();
});


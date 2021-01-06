<?php

use App\Http\Controllers\api\UserApiAuthController;
use App\Http\Controllers\CityController;
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

Route::prefix('auth/')->middleware('guest:api')->group(function(){
    Route::post('login', [UserApiAuthController::class, 'login']);


    Route::post('loginpgt', [UserApiAuthController::class, 'loginGCT']);
});
Route::middleware('auth:api')->group(function(){
    Route::apiResource('cities', CityController::class);

});
Route::prefix('auth/')->middleware('auth:api')->group(function(){
    Route::get('logout', [UserApiAuthController::class, 'logout']);

    Route::get('logoutpgt', [UserApiAuthController::class, 'logoutGCT']);
});

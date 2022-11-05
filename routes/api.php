<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'App\Http\Controllers'], function () {

    Route::group(['prefix' => 'user'], function () {
        Route::post('login', 'AuthController@login');

        Route::post('logout', 'AuthController@logout');
    });

    Route::apiResource('users', 'UserController')->only(['index', 'show', 'store', 'update']);

    Route::apiResource('cars', 'CarController')->only(['index', 'show', 'update']);
    
    Route::group(['middleware' => 'admin', 'as' => 'admin.'], function () {
        Route::apiResource('admin/cars', 'Admin\CarController')->only(['store', 'update', 'destroy']);

        Route::apiResource('admin/users', 'Admin\UserController')->only(['store', 'update', 'destroy']);
    });
});


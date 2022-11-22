<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProxyController;
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


Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'register'])->withoutMiddleware('auth:api');
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware('auth:api');
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('me', [AuthController::class, 'me']);
    });

    Route::group(['prefix' => 'proxies'], function () {
        Route::post('list', [ProxyController::class, 'list']);
        Route::post('export', [ProxyController::class, 'export']);
    });
});


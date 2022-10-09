<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\Auth\RegisterController;
use App\Http\Controllers\API\V1\{CategoryController, UserController, DonationController};
use App\Http\Controllers\API\V1\Auth\LoginController;

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

Route::prefix('v1')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);
    Route::post('forgot-password', LoginController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('users', UserController::class);
        Route::apiResource('donations', DonationController::class);
    });
});


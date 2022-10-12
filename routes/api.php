<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('API\V1')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', 'AuthController@logout');
            Route::get('users', 'UserController@index');
        });
    });
});

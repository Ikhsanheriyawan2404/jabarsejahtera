<?php

use Illuminate\Support\Facades\Route;

Route::namespace('API\V1')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        Route::middleware('auth:api')->group(function () {
            Route::get('users', 'UserController@index');
            Route::post('logout', 'AuthController@logout');
        });
        Route::middleware('admin')->group(function () {
            Route::delete('users/{user}', 'UserController@destroy');
        });
    });
});

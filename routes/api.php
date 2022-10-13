<?php

use Illuminate\Support\Facades\Route;

Route::namespace('API\V1')->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        Route::middleware('auth:api')->group(function () {
            Route::put('donations/{donation}', 'DonationController@update');
            Route::get('users', 'UserController@index');
            Route::get('donations', 'DonationController@index');
            Route::get('donations/{donation}', 'DonationController@show');
            Route::delete('donations/{donation}', 'DonationController@destroy');
            Route::post('donations', 'DonationController@store');
            Route::post('logout', 'AuthController@logout');
        });
        Route::middleware('admin')->group(function () {
            Route::delete('users/{user}', 'UserController@destroy');
        });
    });
});

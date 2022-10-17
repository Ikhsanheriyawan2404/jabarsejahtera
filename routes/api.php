<?php

use Illuminate\Support\Facades\Route;

Route::namespace('API\V1')->group(function () {
    Route::prefix('v1')->group(function () {
        /** Authentication */
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        /** Transactions */
        Route::post('transactions/{donation}', 'TransactionController@store');
        // Route::post('transactions/{transaction}', 'TransactionController@store');
        Route::get('donations', 'DonationController@index');
        Route::get('donations/{id}', 'DonationController@show');
        Route::get('events', 'EventController@index');
        Route::get('events/{id}', 'EventController@show');

        Route::middleware('auth:api')->group(function () {
            Route::post('logout', 'AuthController@logout');
            Route::get('users/{id}', 'UserController@show');
            Route::put('users/{id}', 'UserController@update');

            /** Middleware to handle role admin */
            Route::middleware('admin')->group(function () {
                Route::post('donations', 'DonationController@store');
                Route::put('donations/{donation}', 'DonationController@update');
                Route::delete('donations/{donation}', 'DonationController@destroy');

                Route::post('events', 'EventController@store');
                Route::put('events/{id}', 'EventController@update');
                Route::delete('events/{id}', 'EventController@destroy');

                Route::get('users', 'UserController@index');
                Route::delete('users/{user}', 'UserController@destroy');
            });
        });
    });
});

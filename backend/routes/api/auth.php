<?php

use Illuminate\Support\Facades\Route;

Route::post('/register','AuthController@register')->name('register');
Route::post('/login','AuthController@login')->name('login');
Route::middleware('throttle:10,60')->post('/forgot-password', 'AuthController@forgotPassword');
Route::post('/reset-password', 'AuthController@resetPassword');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/logout','AuthController@logout');
});


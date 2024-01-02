<?php

use Illuminate\Support\Facades\Route;

Route::post('/register','AuthController@register')->name('register');
Route::post('/login','AuthController@login')->name('login');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/logout','AuthController@logout');
});


<?php

use Illuminate\Support\Facades\Route;


Route::post('/register','UserController@register')->name('register');
Route::post('/login','UserController@login')->name('login');


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::put('/update', 'UserController@update');
    Route::patch('/update-password', 'UserController@updatePassword');
});


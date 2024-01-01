<?php

Route::post('/register','UserController@register')->name('register');
Route::post('/login','UserController@login')->name('login');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('/logout','UserController@login')->name('logout');
});


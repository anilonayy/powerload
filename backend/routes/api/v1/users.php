<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::post('/register','UserController@register')->name('register');
Route::post('/login','UserController@login')->name('login');


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::put('/update', [UserController::class,'update']);
    Route::patch('/update-password', 'UserController@updatePassword');
});


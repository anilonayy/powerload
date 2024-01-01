<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::post('/register','UserController@register')->name('register');
Route::post('/login','UserController@login')->name('login');


Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::patch('/', [UserController::class,'update']);
    Route::patch('/update-password', [UserController::class,'updatePassword']);
});


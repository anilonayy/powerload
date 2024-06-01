<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[UserController::class, 'register'])->name('register');
Route::post('/login',[UserController::class, 'login'])->name('login');

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::put('/update', [UserController::class, 'update']);
    Route::patch('/update-password', [UserController::class, 'updatePassword']);
});


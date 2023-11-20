<?php

use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[UserController::class, 'store']);
Route::post('/login',[SessionController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[SessionController::class, 'destroy']);
    Route::get('/user/{user:email}',[UserController::class, 'show']);
});

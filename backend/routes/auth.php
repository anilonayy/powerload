<?php

use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class, 'login'])->name('login');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout',[UserController::class, 'logout']);
    Route::get('/user/{user:email}',[UserController::class, 'show']);
});

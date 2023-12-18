<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class, 'login'])->name('login');

Route::group([
    'prefix' => 'user',
    'middleware' => 'auth:sanctum'
    ], function(){
        Route::post('/logout',[UserController::class, 'logout']);
        Route::get('/{user:email}',[UserController::class, 'show']);
});

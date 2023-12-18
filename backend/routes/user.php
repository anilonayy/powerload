<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group([
    'prefix' => 'user',
    'middleware' => 'auth:sanctum'
    ], function(){

    Route::patch('/', [UserController::class,'update']);
    Route::patch('/update-password', [UserController::class,'updatePassword']);
});


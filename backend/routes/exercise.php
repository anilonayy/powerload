<?php

use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;

Route::get('/exercises',[ExerciseController::class,'index']);

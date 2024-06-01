<?php

use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExerciseController::class, 'index']);

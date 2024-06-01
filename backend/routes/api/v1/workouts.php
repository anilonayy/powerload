<?php

use App\Http\Controllers\WorkoutDayController;
use App\Http\Controllers\WorkoutsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/', [WorkoutsController::class, 'index']);
    Route::get('/details', [WorkoutsController::class, 'allWithDetails']);
    Route::post('/', [WorkoutsController::class, 'store']);

    Route::get('/{workout:id}', [WorkoutsController::class, 'show']);
    Route::get('/{workout}/days/{workout_day}/exercises', [WorkoutDayController::class, 'showExercises']);
    Route::delete('/{workout}',  [WorkoutsController::class, 'destroy']);
    Route::put('/{workout}',  [WorkoutsController::class, 'update']);
});

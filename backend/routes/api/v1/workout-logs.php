<?php

use App\Http\Controllers\WorkoutExerciseLogsController;
use App\Http\Controllers\WorkoutLogsController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/', [WorkoutLogsController::class, 'index']);
    Route::get('/last', [WorkoutLogsController::class, 'last']);
    // Dashboard routes start
    Route::get('/dashboard-stats', [WorkoutLogsController::class, 'stats']);
    Route::get('/personal-records', [WorkoutLogsController::class, 'personalRecords']);
    Route::post('/exercise-history', [WorkoutLogsController::class, 'exerciseHistory']);
    // -----------------------
    Route::get('/{workout_log:id}', [WorkoutLogsController::class, 'show']);
    Route::get('/{workout_log:id}/daily-results', [WorkoutLogsController::class, 'dailyResults']);
    Route::post('/last-or-new', [WorkoutLogsController::class, 'lastOrNew']);
    Route::post('/{workout_log:id}/exercises', [WorkoutExerciseLogsController::class, 'store']);
    Route::patch('/{workout_log:id}/complete', [WorkoutLogsController::class, 'complete']);
    Route::post('/{workout_log:id}/give-up', [WorkoutLogsController::class, 'giveUp']);
    Route::put('/{workout_log:id}', [WorkoutLogsController::class, 'update']);
});

<?php

use App\Http\Controllers\Auth\RegisteredUserNewPasswordController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TrainingExerciseLogsController;
use App\Http\Controllers\TrainingLogsController;
use App\Http\Controllers\TrainingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function() {
    // Trainings Resources
    Route::group(['prefix' => 'trainings'], function(){
        Route::get('/', [TrainingsController::class, 'index']);
        Route::post('/', [TrainingsController::class, 'store']);
        Route::get('/details', [TrainingsController::class, 'allWithDetails']);
        Route::get('/history', [TrainingsController::class, 'history']);
        Route::get('/{training}', [TrainingsController::class, 'show']);
        Route::get('/{training}/days/{training_day}/exercises', [TrainingsController::class, 'showExercises']);
        Route::delete('/{training}', [TrainingsController::class, 'destroy']);
        Route::put('/{training}', [TrainingsController::class, 'update']);
    });

    // On Train Resources (Training Logs)
    Route::group(['prefix' => 'training-logs'], function(){
        Route::get('/last', [TrainingLogsController::class,'last']);
        Route::get('/{training_log}', [TrainingLogsController::class,'show']);
        Route::post('/', [TrainingLogsController::class,'store']);
        Route::patch('/{training_log}/complete', [TrainingLogsController::class,'complete']);
        Route::post('/{training_log}/exercises', [TrainingExerciseLogsController::class,'store']);
        Route::put('/{training_log}', [TrainingLogsController::class,'update']);
    });

    // On Train Resources (Training Logs)
    Route::get('/exercises',[ExerciseController::class,'index']);
});


require_once __DIR__.'/auth.php';
require_once __DIR__.'/user.php';

<?php

use App\Http\Controllers\Auth\RegisteredUserNewPasswordController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\TrainingLogsController;
use App\Http\Controllers\TrainingsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('/user', [UserController::class,'update']);
    Route::patch('/user/update-password', [RegisteredUserNewPasswordController::class,'store']);

    Route::get('/trainings/{training:id}',[TrainingsController::class,'show']);
    Route::get('/trainings/{training:id}/days',[TrainingsController::class,'showDays']);
    Route::get('/trainings/{training:id}/days/{trainingDay:id}/exercises',[TrainingsController::class,'showExercises']);
    Route::delete('/trainings/{training:id}',[TrainingsController::class,'destroy']);
    Route::put('/trainings/{training:id}',[TrainingsController::class,'update']);
    Route::get('/trainings',[TrainingsController::class,'index']);
    Route::post('/trainings',[TrainingsController::class,'store']);
    Route::get('/exercises',[ExerciseController::class,'index']);


    Route::post('/training-logs', [TrainingLogsController::class,'store']);
    Route::get('/training-logs/last', [TrainingLogsController::class,'last']);
});


require_once __DIR__.'/auth.php';

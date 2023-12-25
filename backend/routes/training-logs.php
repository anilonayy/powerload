<?php

use App\Http\Controllers\TrainingExerciseLogsController;
use App\Http\Controllers\TrainingLogsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'training-logs'], function(){
    Route::get('/last', [TrainingLogsController::class,'last']);
    Route::get('/{training_log}', [TrainingLogsController::class,'show']);
    Route::post('/', [TrainingLogsController::class,'store']);
    Route::patch('/{training_log}/complete', [TrainingLogsController::class,'complete']);
    Route::post('/{training_log}/exercises', [TrainingExerciseLogsController::class,'store']);
    Route::put('/{training_log}', [TrainingLogsController::class,'update']);
});

<?php
use App\Http\Controllers\TrainingsController;
use Illuminate\Support\Facades\Route;


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

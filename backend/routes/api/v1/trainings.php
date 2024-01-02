<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/', 'TrainingsController@index');
    Route::get('/details', 'TrainingsController@allWithDetails');
    Route::post('/', 'TrainingsController@store');

    Route::get('/{training}', 'TrainingsController@show');
    Route::get('/{training}/days/{training_day}/exercises', 'TrainingDayController@showExercises');
    Route::delete('/{training}', 'TrainingsController@destroy');
    Route::put('/{training}', 'TrainingsController@update');
});

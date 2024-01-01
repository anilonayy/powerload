<?php
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/', 'TrainingsController@index');
    Route::post('/', 'TrainingsController@store');
    Route::get('/details', 'TrainingController@allWithDetails');

    Route::get('/{training}', 'TrainingsController@show');
    Route::get('/{training}/days/{training_day}/exercises', 'TrainingsController@showExercises');
    Route::delete('/{training}', 'TrainingsController@destroy');
    Route::put('/{training}', 'TrainingsController@update');
});

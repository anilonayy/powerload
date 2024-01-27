<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/', 'WorkoutsController@index');
    Route::get('/details', 'WorkoutsController@allWithDetails');
    Route::post('/', 'WorkoutsController@store');

    Route::get('/{workout:id}', 'WorkoutsController@show');
    Route::get('/{workout}/days/{workout_day}/exercises', 'WorkoutDayController@showExercises');
    Route::delete('/{workout}', 'WorkoutsController@destroy');
    Route::put('/{workout}', 'WorkoutsController@update');
});

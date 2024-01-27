<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/', 'WorkoutLogsController@index');
    Route::get('/last', 'WorkoutLogsController@last');
    // Dashboard routes start
    Route::get('/dashboard-stats', 'WorkoutLogsController@stats');
    Route::get('/personal-records', 'WorkoutLogsController@personalRecords');
    Route::post('/exercise-history', 'WorkoutLogsController@exerciseHistory');
    // -----------------------
    Route::get('/{workout_log:id}', 'WorkoutLogsController@show');
    Route::get('/{workout_log:id}/daily-results', 'WorkoutLogsController@dailyResults');
    Route::post('/last-or-new', 'WorkoutLogsController@lastOrNew');
    Route::post('/{workout_log:id}/exercises','WorkoutExerciseLogsController@store');
    Route::patch('/{workout_log:id}/complete', 'WorkoutLogsController@complete');
    Route::post('/{workout_log:id}/give-up', 'WorkoutLogsController@giveUp');
    Route::put('/{workout_log:id}', 'WorkoutLogsController@update');


});

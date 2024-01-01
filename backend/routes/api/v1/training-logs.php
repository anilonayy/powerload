<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/', 'TrainingLogsController@index');
    Route::get('/last', 'TrainingLogsController@last');
    Route::get('/{training_log}', 'TrainingLogsController@show');
    Route::get('/{training_log}/daily-results', 'TrainingLogsController@dailyResults');
    Route::post('/', 'TrainingLogsController@store');
    Route::post('/{training_log}/exercises','TrainingExerciseLogsController@store');
    Route::patch('/{training_log}/complete', 'TrainingLogsController@complete');
    Route::post('/{training_log}/give-up', 'TrainingLogsController@giveUp');
    Route::put('/{training_log}', 'TrainingLogsController@update');
});

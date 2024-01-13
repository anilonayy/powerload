<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/', 'TrainingLogsController@index');
    Route::get('/last', 'TrainingLogsController@last');
    // Dashboard routes start
    Route::get('/dashboard-stats', 'TrainingLogsController@stats');
    Route::get('/personal-records', 'TrainingLogsController@personalRecords');
    Route::post('/exercise-history', 'TrainingLogsController@exerciseHistory');
    // -----------------------
    Route::get('/{training_log:id}', 'TrainingLogsController@show');
    Route::get('/{training_log:id}/daily-results', 'TrainingLogsController@dailyResults');
    Route::post('/last-or-new', 'TrainingLogsController@lastOrNew');
    Route::post('/{training_log:id}/exercises','TrainingExerciseLogsController@store');
    Route::patch('/{training_log:id}/complete', 'TrainingLogsController@complete');
    Route::post('/{training_log:id}/give-up', 'TrainingLogsController@giveUp');
    Route::put('/{training_log:id}', 'TrainingLogsController@update');


});

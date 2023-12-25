<?php

use App\Http\Controllers\ExerciseController;
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
    require_once __DIR__.'/training.php';

    // On Train Resources (Training Logs)
    require_once __DIR__.'/training-logs.php';

    // On Train Resources (Training Logs)
    require_once __DIR__.'/exercise.php';

});




require_once __DIR__.'/auth.php';
require_once __DIR__.'/user.php';

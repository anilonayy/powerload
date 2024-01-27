<?php

namespace App\Http\Controllers;

use App\Models\WorkoutDay;
use App\Services\WorkoutDay\WorkoutDayServiceInterface;
use Illuminate\Http\JsonResponse;

class WorkoutDayController
{

    protected WorkoutDayServiceInterface $workoutDayService;

    public function __construct(WorkoutDayServiceInterface $workoutDayService)
    {
        $this->workoutDayService = $workoutDayService;
    }

    public function showExercises(WorkoutDay $workoutDay): JsonResponse
    {
        return response()->json($this->workoutDayService->showExercisesOfDay($workoutDay));
    }
}

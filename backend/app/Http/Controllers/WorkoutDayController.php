<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\WorkoutDay;
use App\Services\WorkoutDay\WorkoutDayServiceInterface;
use Illuminate\Http\JsonResponse;

class WorkoutDayController
{
    protected WorkoutDayServiceInterface $workoutDayService;

    /**
     * @param WorkoutDayServiceInterface $workoutDayService
     */
    public function __construct(WorkoutDayServiceInterface $workoutDayService)
    {
        $this->workoutDayService = $workoutDayService;
    }

    /**
     * @param WorkoutDay $workoutDay
     *
     * @return JsonResponse
     */
    public function showExercises(WorkoutDay $workoutDay): JsonResponse
    {
        return Api::ok($this->workoutDayService->showExercisesOfDay($workoutDay));
    }
}

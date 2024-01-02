<?php

namespace App\Http\Controllers;

use App\Models\TrainingDay;
use App\Services\TrainingDay\TrainingDayServiceInterface;
use Illuminate\Http\JsonResponse;

class TrainingDayController
{

    protected TrainingDayServiceInterface $trainingDayService;

    public function __construct(TrainingDayServiceInterface $trainingDayService)
    {
        $this->trainingDayService = $trainingDayService;
    }

    public function showExercises(TrainingDay $trainingDay): JsonResponse
    {
        return response()->json($this->trainingDayService->showExercisesOfDay($trainingDay));
    }
}

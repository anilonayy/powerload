<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\WorkoutExerciseLog\CreateLogRequest;
use App\Models\WorkoutLogs;
use App\Services\WorkoutExerciseLog\WorkoutExerciseLogServiceInterface;
use Illuminate\Http\JsonResponse;

class WorkoutExerciseLogsController extends Controller
{
    protected WorkoutExerciseLogServiceInterface $workoutExerciseLogService;

    /**
     * @param WorkoutExerciseLogServiceInterface $workoutExerciseLogService
     */
    public function __construct(WorkoutExerciseLogServiceInterface $workoutExerciseLogService)
    {
        $this->workoutExerciseLogService = $workoutExerciseLogService;
    }

    /**
     * @param CreateLogRequest $request
     * @param WorkoutLogs $workoutLog
     * @return JsonResponse
     */
    public function store(CreateLogRequest $request, WorkoutLogs $workoutLog): JsonResponse
    {
        return Api::ok($this->workoutExerciseLogService->create($workoutLog, (object)$request));
    }
}

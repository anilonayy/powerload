<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingExerciseLog\CreateLogRequest;
use App\Models\TrainingLogs;
use App\Services\TrainingExerciseLog\TrainingExerciseLogServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;

class TrainingExerciseLogsController extends Controller
{
    use ResponseMessage;

    protected TrainingExerciseLogServiceInterface $trainingExerciseLogService;
    public function __construct(TrainingExerciseLogServiceInterface $trainingExerciseLogService)
    {
        $this->trainingExerciseLogService = $trainingExerciseLogService;
    }

    /**
     * @param CreateLogRequest $request
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function store(CreateLogRequest $request, TrainingLogs $trainingLog): JsonResponse
    {
        return response()->json($this->trainingExerciseLogService->create($trainingLog, (object)$request));
    }
}

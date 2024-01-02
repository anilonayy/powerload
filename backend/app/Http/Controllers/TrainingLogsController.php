<?php

namespace App\Http\Controllers;

use App\Models\TrainingLogs;
use Illuminate\Http\JsonResponse;
use App\Enums\ResponseMessageEnums;
use App\Http\Requests\TrainingLog\UpdateLogRequest;
use App\Services\TrainingLogs\TrainingLogsServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingLogsController extends Controller
{
    use ResponseMessage;

    protected TrainingLogsServiceInterface $trainingLogsService;
    public function __construct(TrainingLogsServiceInterface $trainingLogsService)
    {
        $this->trainingLogsService = $trainingLogsService;
    }

    /**
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function show(TrainingLogs $trainingLog): JsonResponse
    {
        return response()->json($this->trainingLogsService->show($trainingLog));
    }

    public function dailyResults(TrainingLogs $trainingLog): JsonResponse
    {
        return response()->json($this->trainingLogsService->dailyResults($trainingLog));
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->trainingLogsService->index());
    }

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        return response()->json($this->trainingLogsService->store());
    }

    /**
     * @param UpdateLogRequest $request
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function update(UpdateLogRequest $request, TrainingLogs $trainingLog): JsonResponse
    {
        return response()->json($this->trainingLogsService->update($trainingLog, $request->validated()));
    }

    /**
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function complete(TrainingLogs $trainingLog): JsonResponse
    {
        return response()->json($this->trainingLogsService->complete($trainingLog));
    }

    /**
     * @return JsonResponse
     */
    public function last(): JsonResponse
    {
        return response()->json($this->trainingLogsService->last());
    }

    /**
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function giveUp(TrainingLogs $trainingLog): JsonResponse
    {
        return response()->json($this->trainingLogsService->giveUp($trainingLog));
    }

    private function checkIsUsersLog (TrainingLogs $trainingLog): void
    {
        if(auth()->user()->id !== $trainingLog->user_id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

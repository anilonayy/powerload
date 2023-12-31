<?php

namespace App\Http\Controllers;

use App\Models\TrainingLogs;
use Illuminate\Http\JsonResponse;
use App\Enums\ResponseMessageEnums;
use App\Http\Requests\Shared\AllWithFiltersRequest;
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
    public function show(int $id): JsonResponse
    {
        return response()->json($this->trainingLogsService->show($id));
    }

    public function dailyResults(int $id): JsonResponse
    {
        return response()->json($this->trainingLogsService->dailyResults($id));
    }

    /**
     * @return JsonResponse
     */
    public function index(AllWithFiltersRequest $request): JsonResponse
    {
        return response()->json($this->trainingLogsService->index($request->validated()));
    }

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        return response()->json($this->trainingLogsService->store());
    }

    /**
     * @return JsonResponse
     */
    public function lastOrNew(): JsonResponse
    {
        return response()->json($this->trainingLogsService->lastOrNew());
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

    public function stats(): JsonResponse
    {
        return response()->json($this->trainingLogsService->stats());
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

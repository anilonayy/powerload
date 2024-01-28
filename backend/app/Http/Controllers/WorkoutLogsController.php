<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Models\WorkoutLogs;
use Illuminate\Http\JsonResponse;
use App\Enums\ResponseMessageEnums;
use App\Http\Requests\Shared\AllWithFiltersRequest;
use App\Http\Requests\WorkoutLog\ExerciseHistoryRequest;
use App\Http\Requests\WorkoutLog\UpdateLogRequest;
use App\Services\WorkoutLogs\WorkoutLogsServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutLogsController extends Controller
{
    use ResponseMessage;

    protected WorkoutLogsServiceInterface $workoutLogsService;
    public function __construct(WorkoutLogsServiceInterface $workoutLogsService)
    {
        $this->workoutLogsService = $workoutLogsService;
    }

    /**
     * @param WorkoutLogs $workoutLog
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return Api::ok($this->workoutLogsService->show($id));
    }

    public function dailyResults(int $id): JsonResponse
    {
        return Api::ok($this->workoutLogsService->dailyResults($id));
    }

    /**
     * @return JsonResponse
     */
    public function index(AllWithFiltersRequest $request): JsonResponse
    {
        return Api::ok($this->workoutLogsService->index($request->validated()));
    }

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        return Api::ok($this->workoutLogsService->store());
    }

    /**
     * @return JsonResponse
     */
    public function lastOrNew(): JsonResponse
    {
        return Api::ok($this->workoutLogsService->lastOrNew());
    }

    /**
     * @param UpdateLogRequest $request
     * @param WorkoutLogs $workoutLog
     * @return JsonResponse
     */
    public function update(UpdateLogRequest $request, WorkoutLogs $workoutLog): JsonResponse
    {
        return Api::ok($this->workoutLogsService->update($workoutLog, $request->validated()));
    }

    /**
     * @param WorkoutLogs $workoutLog
     * @return JsonResponse
     */
    public function complete(WorkoutLogs $workoutLog): JsonResponse
    {
        $this->workoutLogsService->complete($workoutLog);

        return Api::noContent();
    }

    /**
     * @return JsonResponse
     */
    public function last(): JsonResponse
    {
        return Api::ok($this->workoutLogsService->last());
    }

    public function stats(): JsonResponse
    {
        return Api::ok($this->workoutLogsService->stats());
    }

    public function personalRecords(): JsonResponse
    {
        return Api::ok($this->workoutLogsService->personalRecords());
    }

    public function exerciseHistory(ExerciseHistoryRequest $request): JsonResponse
    {
        return Api::ok($this->workoutLogsService->exerciseHistory((object) $request->validated()));
    }

    /**
     * @param WorkoutLogs $workoutLog
     * @return JsonResponse
     */
    public function giveUp(WorkoutLogs $workoutLog): JsonResponse
    {
        return Api::ok($this->workoutLogsService->giveUp($workoutLog));
    }

    private function checkIsUsersLog (WorkoutLogs $workoutLog): void
    {
        if(auth()->user()->id !== $workoutLog->user_id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

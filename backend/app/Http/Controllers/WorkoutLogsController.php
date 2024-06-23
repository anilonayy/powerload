<?php

namespace App\Http\Controllers;

use App\Enums\ResponseMessageEnums;
use App\Helpers\Api;
use App\Http\Requests\Shared\AllWithFiltersRequest;
use App\Http\Requests\WorkoutLog\ExerciseHistoryRequest;
use App\Http\Requests\WorkoutLog\UpdateLogRequest;
use App\Models\WorkoutLogs;
use App\Services\WorkoutLogs\WorkoutLogsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutLogsController extends Controller
{
    protected WorkoutLogsServiceInterface $workoutLogsService;

    public function __construct(WorkoutLogsServiceInterface $workoutLogsService)
    {
        $this->workoutLogsService = $workoutLogsService;
    }

    /**
     * @param WorkoutLogs $workoutLog
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return Api::ok($this->workoutLogsService->show($id));
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function dailyResults(int $id): JsonResponse
    {
        return Api::ok($this->workoutLogsService->dailyResults($id));
    }

    /**
     * @param AllWithFiltersRequest $request
     *
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
     * @param WorkoutLogs      $workoutLog
     *
     * @return JsonResponse
     */
    public function update(UpdateLogRequest $request, WorkoutLogs $workoutLog): JsonResponse
    {
        return Api::ok($this->workoutLogsService->update($workoutLog, $request->validated()));
    }

    /**
     * @param WorkoutLogs $workoutLog
     *
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

    /**
     * @return JsonResponse
     */
    public function stats(): JsonResponse
    {
        return Api::ok($this->workoutLogsService->stats());
    }

    /**
     * @return JsonResponse
     */
    public function personalRecords(): JsonResponse
    {
        return Api::ok($this->workoutLogsService->personalRecords());
    }

    /**
     * @param ExerciseHistoryRequest $request
     *
     * @return JsonResponse
     */
    public function exerciseHistory(ExerciseHistoryRequest $request): JsonResponse
    {
        return Api::ok($this->workoutLogsService->exerciseHistory((object) $request->validated()));
    }

    /**
     * @param WorkoutLogs $workoutLog
     *
     * @return JsonResponse
     */
    public function giveUp(WorkoutLogs $workoutLog): JsonResponse
    {
        return Api::ok($this->workoutLogsService->giveUp($workoutLog));
    }

    /**
     * @param WorkoutLogs $workoutLog
     *
     * @return void
     */
    private function checkIsUsersLog(WorkoutLogs $workoutLog): void
    {
        if (auth()->user()->id !== $workoutLog->user_id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

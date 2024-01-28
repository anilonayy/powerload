<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Http\Requests\Workout\CreateWorkoutRequest;
use App\Http\Requests\Workout\UpdateWorkoutRequest;
use App\Models\Workout;
use App\Services\Workout\WorkoutServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;

class WorkoutsController extends Controller
{
    use ResponseMessage;

    protected WorkoutServiceInterface $workoutService;

    public function __construct(WorkoutServiceInterface $workoutService)
    {
        $this->workoutService = $workoutService;
    }

    public function index(): JsonResponse
    {
        return Api::ok($this->workoutService->getAll());
    }

    public function allWithDetails(): JsonResponse
    {
        return Api::ok($this->workoutService->getAllWithDetails());
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return Api::ok($this->workoutService->find($id));
    }

    /**
     * @param CreateWorkoutRequest $request
     * @return JsonResponse
     */
    public function store(CreateWorkoutRequest $request): JsonResponse
    {
        return Api::created($this->workoutService->create((object) $request->validated()));
    }

    /**
     * @param Workout $workout
     * @param UpdateWorkoutRequest $request
     * @return JsonResponse
     */
    public function update(Workout $workout, UpdateWorkoutRequest $request): JsonResponse
    {
        return Api::ok($this->workoutService->update($workout, (object) $request->validated()));
    }

    /**
     * @param Workout $workout
     * @return JsonResponse
     */
    public function destroy(Workout $workout): JsonResponse
    {
        $this->workoutService->delete($workout);

        return Api::noContent();
    }
}

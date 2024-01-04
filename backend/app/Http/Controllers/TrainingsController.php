<?php

namespace App\Http\Controllers;

use App\Http\Requests\Training\CreateTrainingRequest;
use App\Http\Requests\Training\UpdateTrainingRequest;
use App\Models\Training;
use App\Services\Training\TrainingServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;

class TrainingsController extends Controller
{
    use ResponseMessage;

    protected TrainingServiceInterface $trainingService;

    public function __construct(TrainingServiceInterface $trainingService)
    {
        $this->trainingService = $trainingService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->trainingService->getAll());
    }

    public function allWithDetails(): JsonResponse
    {
        return response()->json($this->trainingService->getAllWithDetails());
    }

    /**
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->trainingService->get($id));
    }

    /**
     * @param CreateTrainingRequest $request
     * @return JsonResponse
     */
    public function store(CreateTrainingRequest $request): JsonResponse
    {
        return response()->json($this->trainingService->create((object) $request->validated()));
    }

    /**
     * @param Training $training
     * @param UpdateTrainingRequest $request
     * @return JsonResponse
     */
    public function update(Training $training, UpdateTrainingRequest $request): JsonResponse
    {
        return response()->json($this->trainingService->update($training, (object) $request->validated()));
    }

    /**
     * @param Training $training
     * @return JsonResponse
     */
    public function destroy(Training $training): JsonResponse
    {
        return response()->json($this->trainingService->delete($training));
    }
}

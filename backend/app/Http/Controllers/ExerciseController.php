<?php

namespace App\Http\Controllers;

use App\Helpers\Api;
use App\Services\Exercise\ExerciseServiceInterface;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;

class ExerciseController extends Controller
{
    use ResponseMessage;

    protected ExerciseServiceInterface $exerciseService;
    public function __construct(ExerciseServiceInterface $exerciseService)
    {
        $this->exerciseService = $exerciseService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return Api::ok($this->exerciseService->getAll());
    }
}

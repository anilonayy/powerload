<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;

class ExerciseController extends Controller
{
    use ResponseMessage;

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->getSuccessMessage(Exercise::with(['category'])->get()));
    }
}

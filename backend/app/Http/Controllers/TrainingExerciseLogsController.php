<?php

namespace App\Http\Controllers;

use App\Enums\ResponseMessageEnums;
use App\Enums\StatusCodeEnums;
use App\Http\Requests\TrainingExerciseLog\CreateLogRequest;
use App\Models\TrainingExerciseLogs;
use App\Models\TrainingLogs;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Auth;
use Illuminate\Http\JsonResponse;

class TrainingExerciseLogsController extends Controller
{
    use ResponseMessage;

    /**
     * @param CreateLogRequest $request
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function store(TrainingLogs $trainingLog,CreateLogRequest $request): JsonResponse
    {
        $this->checkLogOwner($trainingLog);

        $attributes = $request->validated();
        $responseLogs = [];

        TrainingExerciseLogs::where([
            ['training_log_id', $trainingLog->id],
            ['exercise_id', $attributes['exercise_id']]
        ])->delete();

        foreach($attributes['sets'] as $set) {
            $set['training_log_id'] = $trainingLog->id;
            $set['exercise_id'] = $attributes['exercise_id'];

            $responseLogs[] = TrainingExerciseLogs::create([
                'training_log_id' => $trainingLog->id,
                'exercise_id' => $attributes['exercise_id'],
                'weight' => $set['weight'],
                'reps' => $set['reps'],
                'is_passed' => $set['weight'] === 0 || $set['reps'] === 0
            ]);
        }

        return response()->json($this->getSuccessMessage($responseLogs));
    }

    private function checkLogOwner(TrainingLogs $trainingLog): void
    {
        if($trainingLog->user_id !== auth()->user()->id) {
            throw new Exception(ResponseMessageEnums::FORBIDDEN, StatusCodeEnums::FORBIDDEN);
        }
    }
}

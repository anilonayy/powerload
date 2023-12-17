<?php

namespace App\Http\Controllers;

use App\Models\TrainingExerciseLogs;
use App\Models\TrainingLogs;
use Illuminate\Http\Request;
use App\Traits\ResponseMessage;
use Auth;
use Illuminate\Http\JsonResponse;

class TrainingExerciseLogsController extends Controller
{
    use ResponseMessage;

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingLogs $trainingLogs, Request $request): JsonResponse
    {
        $trainingLogs->user_id === Auth::user()->id || abort(403, 'Yetkiniz yok');

        $responseLogs = [];

        $attributes = $request->validate([
            'sets' => 'sometimes',
            'sets.*.id' => 'required|numeric',
            'sets.*.weight' => 'required|numeric',
            'sets.*.reps' => 'required|numeric',
            'exercise_id' => 'required|exists:exercises,id',
        ]);

        TrainingExerciseLogs::where([['training_log_id', $trainingLogs->id],['exercise_id', $attributes['exercise_id']]])->delete();

        foreach($attributes['sets'] as $set) {
            $set['training_log_id'] = $trainingLogs->id;
            $set['exercise_id'] = $attributes['exercise_id'];

            $responseLogs[] = TrainingExerciseLogs::create([
                'training_log_id' => $trainingLogs->id,
                'exercise_id' => $attributes['exercise_id'],
                'weight' => $set['weight'],
                'reps' => $set['reps']
            ]);
        }

        return response()->json($this->getSuccessMessage($responseLogs));
    }
}

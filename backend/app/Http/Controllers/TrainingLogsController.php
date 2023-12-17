<?php

namespace App\Http\Controllers;

use App\Models\TrainingLogs;
use App\Models\TrainingExerciseLogs;
use Illuminate\Http\JsonResponse;
use App\Enums\ResponseMessageEnums;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingLogsController extends Controller
{
    use ResponseMessage;

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $user = Auth::user();
        $responseLog = new TrainingLogs();

        $lastLog = TrainingLogs::where([
            ['user_id', $user->id],
            ['is_completed', false]
        ])->latest()->first();

        if(!$lastLog) {
            $responseLog = TrainingLogs::create([
                'user_id' => $user->id
            ]);
        } else {
            $responseLog = $lastLog;
        }

        return response()->json($this->getSuccessMessage([
            'id' => $responseLog->id
        ]));
    }

    public function update(TrainingLogs $trainingLogs, Request $request)
    {
        $attributes = $request->validate([
            'training_day_id' => 'sometimes|exists:training_days,id',
            'training_id' => 'sometimes|exists:trainings,id',
            'isCompleted' => 'sometimes|boolean'
        ]);

        $trainingLogs->update($attributes);

        return response()->json($this->getSuccessMessage($trainingLogs));
    }



    public function complete(Request $request)
    {
        $user = Auth::user();

        $trainingLog = TrainingLogs::where([
            ['id', $request->training_log_id],
            ['user_id', $user->id],
            ['is_completed', false]
        ])->latest()->first();

        if (!$trainingLog) {
            throw new NotFoundHttpException(ResponseMessageEnums::NOT_FOUND);
        }

        $trainingLog->update([
            'is_completed' => true
        ]);

        return response()->json($this->getSuccessMessage($trainingLog));
    }

    public function last(TrainingLogs $trainingLogs)
    {
        $user = Auth::user();

        $lastTrainingLog = $trainingLogs->where([
            ['user_id', $user->id],
            ['is_completed', false]
        ])->latest()->first();

        if (!$lastTrainingLog) {
            throw new NotFoundHttpException(ResponseMessageEnums::NOT_FOUND);
        }

        return response()->json($this->getSuccessMessage([
            'id' => $lastTrainingLog->id,
            'training_id' => $lastTrainingLog->training_id,
            'training_day_id' => $lastTrainingLog->training_day_id,
            'exercises' => TrainingExerciseLogs::where('training_log_id', $lastTrainingLog->id)->get()
        ]));
    }
}

<?php

namespace App\Http\Controllers;

use App\Enums\ResponseMessageEnums;
use App\Http\Requests\TrainingExerciseLog\CreateLogRequest;
use App\Models\TrainingExerciseListLogs;
use App\Models\TrainingExerciseLogs;
use App\Models\TrainingLogs;
use Exception;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TrainingExerciseLogsController extends Controller
{
    use ResponseMessage;

    /**
     * @param CreateLogRequest $request
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function store(CreateLogRequest $request, TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkLogOwner($trainingLog);
        $payload = $request->validated();
        $exercise_id = $payload['exercise']['id'];
        $responseLogs = [];

        // Update Is Passed Status
        $training_exercise_log = TrainingExerciseListLogs::where([
            ['training_exercise_log_id', $trainingLog->id],
            ['exercise_id', $exercise_id]
        ])->get()->first();

        $training_exercise_log->update([
            'is_passed' => $payload['exercise']['isPassed']
        ]);

        // Delete Old Logs
        foreach(TrainingExerciseListLogs::where([
            ['training_exercise_log_id', $trainingLog->id],
            ['exercise_id', $exercise_id]
        ])->get() as $log) {
            if ($log->exercise_logs()->count()) {
                $log->exercise_logs()->delete();
            }
        }

        foreach($payload['sets'] as $set) {
            $set['training_log_id'] = $trainingLog->id;
            $set['exercise_id'] = $exercise_id;

            $responseLogs[] = TrainingExerciseLogs::create([
                'training_exercise_list_log_id' => $training_exercise_log->id,
                'exercise_id' => $exercise_id,
                'weight' => $set['weight'],
                'reps' => $set['reps'],
                'started_at' => \Carbon\Carbon::createFromTimestampMs($set['createTime'])->format('Y-m-d H:i:s'),
            ]);
        }

        return response()->json($this->getSuccessMessage($responseLogs));
    }

    private function checkLogOwner(TrainingLogs $trainingLog): void
    {
        if($trainingLog->user_id !== auth()->user()->id) {
            throw new Exception(ResponseMessageEnums::FORBIDDEN, Response::HTTP_FORBIDDEN);
        }
    }
}

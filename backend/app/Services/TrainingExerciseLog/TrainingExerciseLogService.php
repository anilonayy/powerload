<?php

namespace App\Services\TrainingExerciseLog;
use App\Enums\ResponseMessageEnums;
use App\Models\TrainingExerciseListLogs;
use App\Models\TrainingExerciseLogs;
use App\Models\TrainingLogs;
use App\Traits\ResponseMessage;
use Exception;
use Illuminate\Http\Response;

class TrainingExerciseLogService implements TrainingExerciseLogServiceInterface
{
    use ResponseMessage;
    /**
     * @param object $payload
     * @return array
     */
    public function create(TrainingLogs $trainingLog, object $payload): array
    {
        $this->checkLogOwner($trainingLog->user_id);
        $exercise_id = $payload->exercise['id'];
        $responseLogs = [];

        // Update Is Passed Status
        $training_exercise_log = TrainingExerciseListLogs::where([
            ['training_exercise_log_id', $trainingLog->id],
            ['exercise_id', $exercise_id]
        ])->get()->first();

        $training_exercise_log->update([
            'is_passed' => $payload->exercise['isPassed']
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

        foreach($payload->sets as $set) {
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

        return $this->getSuccessMessage($responseLogs);
    }

    /**
     * @param integer $logOwnerId
     * @return void
     */
    public function checkLogOwner(int $logOwnerId): void
    {
        if($logOwnerId !== auth()->user()->id) {
            throw new Exception(ResponseMessageEnums::FORBIDDEN, Response::HTTP_FORBIDDEN);
        }
    }
}

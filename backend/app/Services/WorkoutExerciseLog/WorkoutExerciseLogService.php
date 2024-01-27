<?php

namespace App\Services\WorkoutExerciseLog;
use App\Enums\ResponseMessageEnums;
use App\Models\WorkoutExerciseListLogs;
use App\Models\WorkoutExerciseLogs;
use App\Models\WorkoutLogs;
use App\Traits\ResponseMessage;
use Exception;
use Illuminate\Http\Response;

class WorkoutExerciseLogService implements WorkoutExerciseLogServiceInterface
{
    use ResponseMessage;
    /**
     * @param object $payload
     * @return array
     */
    public function create(WorkoutLogs $workoutLog, object $payload): array
    {
        $this->checkLogOwner($workoutLog->user_id);
        $exercise_id = $payload->exercise['id'];
        $responseLogs = [];

        // Update Is Passed Status
        $workout_exercise_log = WorkoutExerciseListLogs::where([
            ['workout_exercise_log_id', $workoutLog->id],
            ['exercise_id', $exercise_id]
        ])->get()->first();

        $workout_exercise_log->update([
            'is_passed' => $payload->exercise['isPassed']
        ]);

        // Delete Old Logs
        foreach(WorkoutExerciseListLogs::where([
            ['workout_exercise_log_id', $workoutLog->id],
            ['exercise_id', $exercise_id]
        ])->get() as $log) {
            if ($log->exercise_logs()->count()) {
                $log->exercise_logs()->delete();
            }
        }

        foreach($payload->sets as $set) {
            $set['workout_log_id'] = $workoutLog->id;
            $set['exercise_id'] = $exercise_id;

            $responseLogs[] = WorkoutExerciseLogs::create([
                'workout_exercise_list_log_id' => $workout_exercise_log->id,
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

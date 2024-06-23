<?php

namespace App\Services\WorkoutExerciseLog;

use App\Enums\ResponseMessageEnums;
use App\Models\WorkoutExerciseListLogs;
use App\Models\WorkoutExerciseLogs;
use App\Models\WorkoutLogs;
use App\Traits\ResponseMessage;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class WorkoutExerciseLogService implements WorkoutExerciseLogServiceInterface
{
    use ResponseMessage;

    /**
     * @param WorkoutLogs $workoutLog
     * @param object $payload
     *
     * @throws Exception
     * @return Collection
     */
    public function create(WorkoutLogs $workoutLog, object $payload): Collection
    {
        $this->checkLogOwner($workoutLog->user_id);
        $exercise_id = $payload->exercise['id'];
        $responseLogs = [];

        // Update Is Passed Status
        $workout_exercise_log = WorkoutExerciseListLogs::where([
            ['workout_exercise_log_id', $workoutLog->id],
            ['exercise_id', $exercise_id],
        ])->get()->first();

        $workout_exercise_log->update([
            'is_passed' => $payload->exercise['isPassed'],
        ]);

        // Delete Old Logs
        foreach (WorkoutExerciseListLogs::where([
            ['workout_exercise_log_id', $workoutLog->id],
            ['exercise_id', $exercise_id],
        ])->get() as $log) {
            if ($log->exercise_logs()->count()) {
                $log->exercise_logs()->delete();
            }
        }

        foreach ($payload->sets as $set) {
            $set['workout_log_id'] = $workoutLog->id;
            $set['exercise_id'] = $exercise_id;

            $responseLogs[] = WorkoutExerciseLogs::create([
                'workout_log_id' => $workoutLog->id,
                'exercise_id' => $exercise_id,
                'workout_exercise_list_log_id' => $workout_exercise_log->id,
                'weight' => $set['weight'],
                'reps' => $set['reps'],
                'started_at' => Carbon::createFromTimestampMs($set['createTime'])->format('Y-m-d H:i:s'),
            ]);
        }

        return collect($responseLogs);
    }

    /**
     * @param int $logOwnerId
     *
     * @throws Exception
     * @return void
     */
    private function checkLogOwner(int $logOwnerId): void
    {
        if ($logOwnerId !== auth()->user()->id) {
            throw new Exception(ResponseMessageEnums::FORBIDDEN, Response::HTTP_FORBIDDEN);
        }
    }
}

<?php

namespace App\Services\WorkoutExerciseLog;

use App\Models\WorkoutLogs;

interface WorkoutExerciseLogServiceInterface
{
    /**
     * @param object $payload
     * @return array
     */
    public function create(WorkoutLogs $workoutLog, object $payload): array;

    /**
     * @param WorkoutLogs $workoutLog
     * @return void
     */
    public function checkLogOwner(int $logOwnerId): void;
}

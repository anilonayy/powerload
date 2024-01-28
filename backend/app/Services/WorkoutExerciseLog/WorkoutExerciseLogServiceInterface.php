<?php

namespace App\Services\WorkoutExerciseLog;

use App\Models\WorkoutLogs;
use Illuminate\Support\Collection;

interface WorkoutExerciseLogServiceInterface
{
    /**
     * Create Workout Exercise Logs.
     *
     * @param object $payload
     * @return Collection
     */
    public function create(WorkoutLogs $workoutLog, object $payload): Collection;
}

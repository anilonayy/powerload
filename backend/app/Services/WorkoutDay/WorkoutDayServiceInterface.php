<?php

namespace App\Services\WorkoutDay;

use App\Models\WorkoutDay;
use Illuminate\Database\Eloquent\Collection;

interface WorkoutDayServiceInterface
{
    /**
     * Show exercises of workout day.
     *
     * @param WorkoutDay $workoutDay
     * @return Collection
     */
    public function showExercisesOfDay(WorkoutDay $workoutDay): Collection;
}

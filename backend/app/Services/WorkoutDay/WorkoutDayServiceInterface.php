<?php

namespace App\Services\WorkoutDay;

use App\Models\WorkoutDay;

interface WorkoutDayServiceInterface
{
    /**
     * @param WorkoutDay $workoutDay
     * @return array
     */
    public function showExercisesOfDay(WorkoutDay $workoutDay ): array;


    /**
     * @param WorkoutDay $workoutDay
     * @return void
     */
    public function checkWorkoutDayOwner(WorkoutDay $workoutDay): void;
}

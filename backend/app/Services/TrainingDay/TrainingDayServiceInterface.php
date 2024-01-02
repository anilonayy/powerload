<?php

namespace App\Services\TrainingDay;

use App\Models\TrainingDay;

interface TrainingDayServiceInterface
{
    /**
     * @param TrainingDay $trainingDay
     * @return array
     */
    public function showExercisesOfDay(TrainingDay $trainingDay ): array;


    /**
     * @param TrainingDay $trainingDay
     * @return void
     */
    public function checkTrainingDayOwner(TrainingDay $trainingDay): void;
}

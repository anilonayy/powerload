<?php

namespace App\Services\TrainingExerciseLog;

use App\Models\TrainingLogs;

interface TrainingExerciseLogServiceInterface
{
    /**
     * @param object $payload
     * @return array
     */
    public function create(TrainingLogs $trainingLog, object $payload): array;

    /**
     * @param TrainingLogs $trainingLog
     * @return void
     */
    public function checkLogOwner(int $logOwnerId): void;
}

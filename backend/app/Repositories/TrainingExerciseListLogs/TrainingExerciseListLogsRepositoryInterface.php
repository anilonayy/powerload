<?php

namespace App\Repositories\TrainingExerciseListLogs;

use App\Models\TrainingExerciseListLogs;
use Illuminate\Support\Collection;

interface TrainingExerciseListLogsRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): TrainingExerciseListLogs;
    public function create(array $data) : TrainingExerciseListLogs;
    public function update(array $data): TrainingExerciseListLogs;
    public function delete(int $id): void;
}

<?php

namespace App\Repositories\WorkoutExerciseListLogs;

use App\Models\WorkoutExerciseListLogs;
use Illuminate\Support\Collection;

interface WorkoutExerciseListLogsRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): WorkoutExerciseListLogs;
    public function create(array $data) : WorkoutExerciseListLogs;
    public function update(array $data): WorkoutExerciseListLogs;
    public function delete(int $id): void;
}

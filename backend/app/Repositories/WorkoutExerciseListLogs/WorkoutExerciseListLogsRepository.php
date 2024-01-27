<?php

namespace App\Repositories\WorkoutExerciseListLogs;

use App\Models\WorkoutExerciseListLogs;
use Illuminate\Support\Collection;

class WorkoutExerciseListLogsRepository implements WorkoutExerciseListLogsRepositoryInterface
{
    public function all(): Collection
    {
        return WorkoutExerciseListLogs::all();
    }

    public function find(int $id): WorkoutExerciseListLogs
    {
        return WorkoutExerciseListLogs::findOrFail($id);
    }

    public function create(array $data) : WorkoutExerciseListLogs
    {
        return WorkoutExerciseListLogs::create($data);
    }

    public function update(array $data): WorkoutExerciseListLogs
    {
        $workoutExerciseListLogs = WorkoutExerciseListLogs::findOrFail($data['id']);
        $workoutExerciseListLogs->update($data);
        return $workoutExerciseListLogs;
    }

    public function delete(int $id): void
    {
        $workoutExerciseListLogs = WorkoutExerciseListLogs::findOrFail($id);
        $workoutExerciseListLogs->delete();
    }
}

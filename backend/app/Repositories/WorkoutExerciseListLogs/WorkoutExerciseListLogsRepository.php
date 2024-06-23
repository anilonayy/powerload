<?php

namespace App\Repositories\WorkoutExerciseListLogs;

use App\Models\WorkoutExerciseListLogs;
use Illuminate\Support\Collection;

class WorkoutExerciseListLogsRepository implements WorkoutExerciseListLogsRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return WorkoutExerciseListLogs::all();
    }

    /**
     * @param int $id
     *
     * @return WorkoutExerciseListLogs
     */
    public function find(int $id): WorkoutExerciseListLogs
    {
        return WorkoutExerciseListLogs::findOrFail($id);
    }

    /**
     * @param array $data
     *
     * @return WorkoutExerciseListLogs
     */
    public function create(array $data): WorkoutExerciseListLogs
    {
        return WorkoutExerciseListLogs::create($data);
    }

    /**
     * @param array $data
     *
     * @return WorkoutExerciseListLogs
     */
    public function update(array $data): WorkoutExerciseListLogs
    {
        $workoutExerciseListLogs = WorkoutExerciseListLogs::findOrFail($data['id']);
        $workoutExerciseListLogs->update($data);

        return $workoutExerciseListLogs;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $workoutExerciseListLogs = WorkoutExerciseListLogs::findOrFail($id);
        $workoutExerciseListLogs->delete();
    }
}

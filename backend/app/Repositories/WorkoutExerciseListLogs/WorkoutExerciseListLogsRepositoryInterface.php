<?php

namespace App\Repositories\WorkoutExerciseListLogs;

use App\Models\WorkoutExerciseListLogs;
use Illuminate\Support\Collection;

interface WorkoutExerciseListLogsRepositoryInterface
{
    /**
     * Get all WorkoutExerciseListLogs.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find WorkoutExerciseListLogs by id.
     *
     * @param int $id
     *
     * @return WorkoutExerciseListLogs
     */
    public function find(int $id): WorkoutExerciseListLogs;

    /**
     * Create WorkoutExerciseListLogs.
     *
     * @param array $data
     *
     * @return WorkoutExerciseListLogs
     */
    public function create(array $data): WorkoutExerciseListLogs;

    /**
     * Update WorkoutExerciseListLogs.
     *
     * @param array $data
     *
     * @return WorkoutExerciseListLogs
     */
    public function update(array $data): WorkoutExerciseListLogs;

    /**
     * Delete WorkoutExerciseListLogs.
     *
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void;
}

<?php

namespace App\Repositories\WorkoutLogs;

use App\Models\WorkoutLogs;
use Illuminate\Support\Collection;

interface WorkoutLogsRepositoryInterface
{
    /**
     * Get all Workout Logs.
     *
     * @param array $payload
     * @return mixed
     */
    public function all(array $payload): mixed;

    /**
     * Find Workout Logs by id
     *
     * @param integer $id
     * @return WorkoutLogs
     */
    public function find(int $id): WorkoutLogs;

    /**
     * Find Workout Logs by id with details.
     *
     * @param integer $id
     * @return WorkoutLogs
     */
    public function findWithDetails(int $id): WorkoutLogs;

    /**
     * Get workout results by the day.
     *
     * @param integer $id
     * @return WorkoutLogs
     */
    public function dailyResults(int $id): WorkoutLogs;

    /**
     * Create Workout Logs
     *
     * @param array $data
     * @return WorkoutLogs
     */
    public function create(array $data) : WorkoutLogs;

    /**
     * Create Workout Logs
     *
     * @param array $data
     * @return WorkoutLogs
     */
    public function lastOrNew(): WorkoutLogs;

    /**
     * Update Workout Logs
     *
     * @param array $data
     * @return WorkoutLogs
     */
    public function update(array $data): WorkoutLogs;

    /**
     * Delete Workout Logs
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Get total completed workout count.
     *
     * @return integer
     */
    public function getWorkoutCounts(): int;

    /**
     * Get total completed workout average time.
     *
     * @return string
     */
    public function getWorkoutTimeAverage(): string;

    /**
     * Get total completed workout exercise count average.
     *
     * @return float|null
     */
    public function getWorkoutExerciseAverage(): float|null;

    /**
     * Get workout history.
     *
     * @param object $payload
     * @return Collection
     */
    public function exerciseHistory(object $payload): Collection;

    /**
     * Get your Personal Records (PR)
     *
     * @return Collection
     */
    public function personalRecords(): Collection;
}

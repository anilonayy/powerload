<?php

namespace App\Services\WorkoutLogs;

use App\Models\WorkoutLogs;
use Illuminate\Support\Collection;

interface WorkoutLogsServiceInterface
{
    /**
     * Get all workout logs.
     *
     * @param array $payload
     * @return mixed
     */
    public function index(array $payload): mixed;

    /**
     * Get workout log by id.
     *
     * @param integer $id
     * @return mixed
     */
    public function show(int $id): mixed;

    /**
     * Get workout results by the day.
     *
     * @param integer $id
     * @return mixed
     */
    public function dailyResults(int $id): mixed;

    /**
     * Create workout log.
     *
     * @return WorkoutLogs
     */
    public function store(): WorkoutLogs;

    /**
     * Find last workout or create new one.
     *
     * @return WorkoutLogs
     */
    public function lastOrNew(): WorkoutLogs;

    /**
     * Update workout log.
     *
     * @param WorkoutLogs $workoutLog
     * @param array $payload
     * @return array
     */
    public function update(WorkoutLogs $workoutLog, array $payload): array;

    /**
     * Complete workout log.
     *
     * @param WorkoutLogs $workoutLog
     * @return void
     */
    public function complete(WorkoutLogs $workoutLog): void;

    /**
     * Get last workout log.
     *
     * @return array
     */
    public function last(): array;

    /**
     * Get dashboard stats.
     *
     * @return array
     */
    public function stats(): array;

    /**
     * Get personal records.
     *
     * @return Collection
     */
    public function personalRecords(): Collection;

    /**
     * Get exercise history.
     *
     * @param object $payload
     * @return Collection
     */
    public function exerciseHistory(object $payload): Collection;

    /**
     * Give up workout.
     *
     * @param WorkoutLogs $workoutLog
     * @return WorkoutLogs
     */
    public function giveUp(WorkoutLogs $workoutLog): WorkoutLogs;
}

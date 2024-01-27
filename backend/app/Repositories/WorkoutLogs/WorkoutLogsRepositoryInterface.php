<?php

namespace App\Repositories\WorkoutLogs;

use App\Models\WorkoutLogs;
use Illuminate\Support\Collection;

interface WorkoutLogsRepositoryInterface
{
    public function all(array $payload): Collection;
    public function find(int $id): WorkoutLogs;
    public function findWithDetails(int $id): WorkoutLogs;
    public function dailyResults(int $id): WorkoutLogs;
    public function create(array $data) : WorkoutLogs;
    public function lastOrNew(): WorkoutLogs;
    public function update(array $data): WorkoutLogs;
    public function delete(int $id): void;
    public function getWorkoutCounts(): int;
    public function getWorkoutTimeAverage(): string;
    public function getWorkoutExerciseAverage(): float|null;
    public function exerciseHistory(object $payload): Collection;
    public function personalRecords(): Collection;
}

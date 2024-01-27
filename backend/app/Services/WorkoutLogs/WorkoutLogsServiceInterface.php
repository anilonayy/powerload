<?php

namespace App\Services\WorkoutLogs;

use App\Models\WorkoutLogs;

interface WorkoutLogsServiceInterface
{
    public function index(array $payload): array;
    public function show(int $id): array;
    public function dailyResults(int $id): array;
    public function store(): array;
    public function lastOrNew(): array;
    public function update(WorkoutLogs $workoutLog, array $payload): array;
    public function complete(WorkoutLogs $workoutLog): array;
    public function last(): array;
    public function stats(): array;
    public function personalRecords(): array;
    public function exerciseHistory(object $payload): array;
    public function giveUp(WorkoutLogs $workoutLog): array;
}

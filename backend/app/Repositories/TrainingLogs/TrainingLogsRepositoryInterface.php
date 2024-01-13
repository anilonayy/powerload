<?php

namespace App\Repositories\TrainingLogs;

use App\Models\TrainingLogs;
use Illuminate\Support\Collection;

interface TrainingLogsRepositoryInterface
{
    public function all(array $payload): Collection;
    public function find(int $id): TrainingLogs;
    public function findWithDetails(int $id): TrainingLogs;
    public function dailyResults(int $id): TrainingLogs;
    public function create(array $data) : TrainingLogs;
    public function lastOrNew(): TrainingLogs;
    public function update(array $data): TrainingLogs;
    public function delete(int $id): void;
    public function getTrainingCounts(): int;
    public function getTrainingTimeAverage(): string;
    public function getTrainingExerciseAverage(): float|null;
    public function exerciseHistory(object $payload): Collection;
    public function personalRecords(): Collection;
}

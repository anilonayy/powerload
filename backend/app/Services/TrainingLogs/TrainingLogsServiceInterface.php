<?php

namespace App\Services\TrainingLogs;

use App\Models\TrainingLogs;

interface TrainingLogsServiceInterface
{
    public function index(array $payload): array;
    public function show(int $id): array;
    public function dailyResults(int $id): array;
    public function store(): array;
    public function lastOrNew(): array;
    public function update(TrainingLogs $trainingLog, array $payload): array;
    public function complete(TrainingLogs $trainingLog): array;
    public function last(): array;
    public function stats(): array;
    public function personalRecords(): array;
    public function giveUp(TrainingLogs $trainingLog): array;
}

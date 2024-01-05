<?php

namespace App\Services\TrainingLogs;

use App\Http\Requests\TrainingLog\UpdateLogRequest;
use App\Models\TrainingLogs;
use Illuminate\Http\JsonResponse;

interface TrainingLogsServiceInterface
{
    public function index(): array;
    public function show(int $id): array;
    public function dailyResults(int $id): array;
    public function store(): array;
    public function lastOrNew(): array;
    public function update(TrainingLogs $trainingLog, array $payload): array;
    public function complete(TrainingLogs $trainingLog): array;
    public function last(): array;
    public function giveUp(TrainingLogs $trainingLog): array;
}

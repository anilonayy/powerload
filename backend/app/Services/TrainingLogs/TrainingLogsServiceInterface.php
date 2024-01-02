<?php

namespace App\Services\TrainingLogs;

use App\Http\Requests\TrainingLog\UpdateLogRequest;
use App\Models\TrainingLogs;
use Illuminate\Http\JsonResponse;

interface TrainingLogsServiceInterface
{
    public function show(TrainingLogs $trainingLog): array;
    public function dailyResults(TrainingLogs $trainingLog): array;
    public function index(): array;
    public function store(): array;
    public function update(TrainingLogs $trainingLog, array $payload): array;
    public function complete(TrainingLogs $trainingLog): array;
    public function last(): array;
    public function giveUp(TrainingLogs $trainingLog): array;
}

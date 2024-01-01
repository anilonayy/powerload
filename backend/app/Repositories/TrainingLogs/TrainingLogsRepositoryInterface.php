<?php

namespace App\Repositories\TrainingLogs;

use App\Models\TrainingLogs;
use Illuminate\Support\Collection;

interface TrainingLogsRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): TrainingLogs;
    public function create(array $data) : TrainingLogs;
    public function update(array $data): TrainingLogs;
    public function delete(int $id): void;
}

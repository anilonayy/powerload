<?php

namespace App\Repositories\TrainingLogs;

use App\Models\TrainingLogs;
use Illuminate\Support\Collection;

class TrainingLogsRepository implements TrainingLogsRepositoryInterface
{
    public function all(): Collection
    {
        return TrainingLogs::all();
    }

    public function find(int $id): TrainingLogs
    {
        return TrainingLogs::findOrFail($id);
    }

    public function create(array $data) : TrainingLogs
    {
        return TrainingLogs::create($data);
    }

    public function update(array $data): TrainingLogs
    {
        $trainingLogs = TrainingLogs::findOrFail($data['id']);
        $trainingLogs->update($data);
        return $trainingLogs;
    }

    public function delete(int $id): void
    {
        $trainingLogs = TrainingLogs::findOrFail($id);
        $trainingLogs->delete();
    }
}

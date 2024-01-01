<?php

namespace App\Repositories\TrainingExerciseListLogs;

use App\Models\TrainingExerciseListLogs;
use Illuminate\Support\Collection;

class TrainingExerciseListLogsRepository implements TrainingExerciseListLogsRepositoryInterface
{
    public function all(): Collection
    {
        return TrainingExerciseListLogs::all();
    }

    public function find(int $id): TrainingExerciseListLogs
    {
        return TrainingExerciseListLogs::findOrFail($id);
    }

    public function create(array $data) : TrainingExerciseListLogs
    {
        return TrainingExerciseListLogs::create($data);
    }

    public function update(array $data): TrainingExerciseListLogs
    {
        $trainingExerciseListLogs = TrainingExerciseListLogs::findOrFail($data['id']);
        $trainingExerciseListLogs->update($data);
        return $trainingExerciseListLogs;
    }

    public function delete(int $id): void
    {
        $trainingExerciseListLogs = TrainingExerciseListLogs::findOrFail($id);
        $trainingExerciseListLogs->delete();
    }
}

<?php

namespace App\Repositories\Trainings;

use App\Models\Training;
use Illuminate\Support\Collection;

class TrainingRepository implements TrainingRepositoryInterface
{
    public function all(): Collection
    {
        return Training::all();
    }

    public function find(int $id): Training
    {
        return Training::findOrFail($id);
    }

    public function create(array $data) : Training
    {
        return Training::create($data);
    }

    public function update(array $data): Training
    {
        $training = Training::findOrFail($data['id']);

        $training->update($data);

        return $training;
    }

    public function delete(int $id): void
    {
        $training = Training::findOrFail($id);

        $training->delete();
    }
}

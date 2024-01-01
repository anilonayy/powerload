<?php

namespace App\Repositories\TrainingDays;

use App\Models\TrainingDay;
use Illuminate\Support\Collection;

class TrainingDayRepository implements TrainingDayRepositoryInterface
{
    public function all(): Collection
    {
        return TrainingDay::all();
    }

    public function find(int $id): TrainingDay
    {
        return TrainingDay::findOrFail($id);
    }

    public function create(array $data) : TrainingDay
    {
        return TrainingDay::create($data);
    }

    public function update(array $data): TrainingDay
    {
        $trainingDay = TrainingDay::findOrFail($data['id']);

        $trainingDay->update($data);

        return $trainingDay;
    }

    public function delete(int $id): void
    {
        $trainingDay = TrainingDay::findOrFail($id);

        $trainingDay->delete();
    }
}

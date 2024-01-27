<?php

namespace App\Repositories\WorkoutDays;

use App\Models\WorkoutDay;
use Illuminate\Support\Collection;

class WorkoutDayRepository implements WorkoutDayRepositoryInterface
{
    public function all(): Collection
    {
        return WorkoutDay::all();
    }

    public function find(int $id): WorkoutDay
    {
        return WorkoutDay::findOrFail($id);
    }

    public function create(array $data) : WorkoutDay
    {
        return WorkoutDay::create($data);
    }

    public function update(array $data): WorkoutDay
    {
        $workoutDay = WorkoutDay::findOrFail($data['id']);

        $workoutDay->update($data);

        return $workoutDay;
    }

    public function delete(int $id): void
    {
        $workoutDay = WorkoutDay::findOrFail($id);

        $workoutDay->delete();
    }
}

<?php

namespace App\Repositories\WorkoutDays;

use App\Models\WorkoutDay;
use Illuminate\Support\Collection;

class WorkoutDayRepository implements WorkoutDayRepositoryInterface
{
    /**
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return WorkoutDay::all();
    }

    /**
     *
     * @param integer $id
     * @return WorkoutDay
     */
    public function find(int $id): WorkoutDay
    {
        return WorkoutDay::findOrFail($id);
    }

    /**
     *
     * @param array $data
     * @return WorkoutDay
     */
    public function create(array $data) : WorkoutDay
    {
        return WorkoutDay::create($data);
    }

    /**
     *
     * @param array $data
     * @return WorkoutDay
     */
    public function update(array $data): WorkoutDay
    {
        $workoutDay = WorkoutDay::findOrFail($data['id']);

        $workoutDay->update($data);

        return $workoutDay;
    }

    /**
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $workoutDay = WorkoutDay::findOrFail($id);

        $workoutDay->delete();
    }
}

<?php

namespace App\Repositories\WorkoutDays;

use App\Models\WorkoutDay;
use Illuminate\Support\Collection;

interface WorkoutDayRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): WorkoutDay;
    public function create(array $data) : WorkoutDay;
    public function update(array $data): WorkoutDay;
    public function delete(int $id): void;
}

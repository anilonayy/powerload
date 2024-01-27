<?php

namespace App\Repositories\Workouts;

use App\Models\Workout;
use Illuminate\Support\Collection;

interface WorkoutRepositoryInterface
{
    public function all(): Collection;
    public function allWithDetails(): Collection;
    public function create(object $payload): Workout;
    public function find(int $id): Workout;
    public function update(Workout $workout, object $payload): Workout;
    public function delete(Workout $workout): void;
}

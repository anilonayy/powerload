<?php

namespace App\Repositories\Workouts;

use App\Models\Workout;
use Illuminate\Support\Collection;

interface WorkoutRepositoryInterface
{
    /**
     * Get all workout resources.
     *
     * @param object $payload
     * @return Collection
     */
    public function all(object $payload): Collection;

    /**
     * Get all workout resources by paginate.
     *
     * @param object $payload
     * @return array
     */
    public function paginate(object $payload): array;

    /**
     * Get all workout resources with details.
     *
     * @return Collection
     */
    public function allWithDetails(): Collection;

    /**
     * Create workout resource.
     *
     * @param object $payload
     * @return Workout
     */
    public function create(object $payload): Workout;

    /**
     * Find workout resource by id.
     *
     * @param integer $id
     * @return Workout
     */
    public function find(int $id): Workout;

    /**
     * Update workout resource.
     *
     * @param Workout $workout
     * @param object $payload
     * @return Workout
     */
    public function update(Workout $workout, object $payload): Workout;

    /**
     * Delete workout resource.
     *
     * @param Workout $workout
     * @return void
     */
    public function delete(Workout $workout): void;
}

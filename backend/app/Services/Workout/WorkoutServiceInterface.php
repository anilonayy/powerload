<?php

namespace App\Services\Workout;

use App\Models\Workout;
use Illuminate\Support\Collection;

interface WorkoutServiceInterface
{
    /**
     * Create workout resource.
     *
     * @param Workout $payload
     * @return array
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
     * @param int $id
     * @param object $payload
     * @return Workout
     */
    public function update(Workout $workout, object $payload): Workout;

    /**
     * Delete workout resource.
     *
     * @param int $id
     * @return void
     */
    public function delete(Workout $workout): void;

    /**
     *  Get all workout resources.
     *
     * @param object $payload
     * @return array
     */
    public function getAll(object $payload): array;

    /**
     * Get all workout resources with details.
     *
     * @return Collection
     */
    public function getAllWithDetails(): Collection;
}

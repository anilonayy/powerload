<?php

namespace App\Repositories\WorkoutDays;

use App\Models\WorkoutDay;
use Illuminate\Support\Collection;

interface WorkoutDayRepositoryInterface
{
    /**
     * Get all workout day resources.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find workout day resource by id.
     *
     * @param integer $id
     * @return WorkoutDay
     */
    public function find(int $id): WorkoutDay;

    /**
     * Create workout day resource.
     *
     * @param array $data
     * @return WorkoutDay
     */
    public function create(array $data) : WorkoutDay;

    /**
     * Update workout day resource.
     *
     * @param array $data
     * @return WorkoutDay
     */
    public function update(array $data): WorkoutDay;

    /**
     * Delete workout day resource.
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void;
}

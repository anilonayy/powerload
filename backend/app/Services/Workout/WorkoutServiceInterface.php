<?php

namespace App\Services\Workout;

use App\Models\Workout;
use App\Models\WorkoutDay;

interface WorkoutServiceInterface
{
    /**
     * @param object $payload
     * @return array
     */
    public function create(object $payload): array;

    /**
     * @param integer $id
     * @return array
     */
    public function find(int $id): array;

    /**
     * @param int $id
     * @param object $payload
     * @return array
     */
    public function update(Workout $workout, object $payload): array;

    /**
     * @param int $id
     * @return array
     */
    public function delete(Workout $workout): array;

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @return array
     */
    public function getAllWithDetails(): array;

    /**
     * @param Workout $workout
     * @param array $payload
     * @return void
     */
}

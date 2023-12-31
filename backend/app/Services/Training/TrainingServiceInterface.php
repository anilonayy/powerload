<?php

namespace App\Services\Training;

use App\Models\Training;
use App\Models\TrainingDay;

interface TrainingServiceInterface
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
    public function update(Training $training, object $payload): array;

    /**
     * @param int $id
     * @return array
     */
    public function delete(Training $training): array;

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @return array
     */
    public function getAllWithDetails(): array;

    /**
     * @param Training $training
     * @param array $payload
     * @return void
     */
}

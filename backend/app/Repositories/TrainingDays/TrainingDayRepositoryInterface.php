<?php

namespace App\Repositories\TrainingDays;

use App\Models\TrainingDay;
use Illuminate\Support\Collection;

interface TrainingDayRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): TrainingDay;
    public function create(array $data) : TrainingDay;
    public function update(array $data): TrainingDay;
    public function delete(int $id): void;
}

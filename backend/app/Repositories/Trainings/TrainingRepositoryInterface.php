<?php

namespace App\Repositories\Trainings;

use App\Models\Training;
use Illuminate\Support\Collection;

interface TrainingRepositoryInterface
{
    public function all(): Collection;
    public function allWithDetails(): Collection;
    public function create(object $payload): Training;
    public function find(int $id): Training;
    public function update(Training $training, object $payload): Training;
    public function delete(Training $training): void;
}

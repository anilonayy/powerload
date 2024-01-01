<?php

namespace App\Repositories\Trainings;

use App\Models\Training;
use Illuminate\Support\Collection;

interface TrainingRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): Training;
    public function create(array $data) : Training;
    public function update(array $data): Training;
    public function delete(int $id): void;
}

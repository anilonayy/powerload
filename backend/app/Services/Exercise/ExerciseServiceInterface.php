<?php

namespace App\Services\Exercise;

use Illuminate\Database\Eloquent\Collection;

interface ExerciseServiceInterface
{
    /**
     * Get all exercise resources.
     *
     * @return Collection
     */
    public function getAll(): Collection;
}

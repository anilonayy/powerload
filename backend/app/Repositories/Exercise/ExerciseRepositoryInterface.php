<?php

namespace App\Repositories\Exercise;

use Illuminate\Support\Collection;

interface ExerciseRepositoryInterface
{
    /**
     * Get all exercise resources.
     *
     * @return Collection
     */
    public function all(): Collection;
}

<?php

namespace App\Repositories\Exercise;

use Illuminate\Support\Collection;

interface ExerciseRepositoryInterface
{
    public function all(): Collection;
}

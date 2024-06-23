<?php

namespace App\Repositories\Exercise;

use App\Models\Exercise;
use Illuminate\Support\Collection;

class ExerciseRepository implements ExerciseRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return Exercise::with(['category' => function ($query) {
            $query->select(['id', 'name']);
        }])
        ->select(['id', 'name', 'exercise_categories_id'])
        ->get();
    }
}

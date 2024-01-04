<?php

namespace App\Repositories\Exercise;

use App\Models\Exercise;
use App\Repositories\General\GeneralRepository;

class ExerciseRepository extends GeneralRepository implements ExerciseRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Exercise::class);
    }
}

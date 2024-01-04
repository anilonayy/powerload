<?php

namespace App\Services\Exercise;

use App\Models\Exercise;
use App\Traits\ResponseMessage;

class ExerciseService implements ExerciseServiceInterface
{
    use ResponseMessage;
    protected ExerciseServiceInterface $exerciseRepository;
    public function __construct(ExerciseServiceInterface $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    public function getAll(): array
    {
        return $this->getSuccessMessage(Exercise::with(['category'])->get());
    }
}

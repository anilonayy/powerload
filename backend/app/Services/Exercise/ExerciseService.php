<?php

namespace App\Services\Exercise;

use App\Models\Exercise;
use App\Traits\ResponseMessage;

class ExerciseService implements ExerciseServiceInterface
{
    use ResponseMessage;
    public function getAll(): array
    {
        return $this->getSuccessMessage(Exercise::with(['category'])->get());
    }
}

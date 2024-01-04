<?php

namespace App\Repositories\Trainings;

use App\Models\Training;
use App\Repositories\General\GeneralRepository;

class TrainingRepository extends GeneralRepository implements TrainingRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(Training::class);
    }
}

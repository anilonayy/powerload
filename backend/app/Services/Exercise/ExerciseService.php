<?php

namespace App\Services\Exercise;

use App\Repositories\Exercise\ExerciseRepositoryInterface;
use App\Traits\ResponseMessage;

class ExerciseService implements ExerciseServiceInterface
{
    use ResponseMessage;
    protected ExerciseRepositoryInterface $exerciseRepository;
    public function __construct(ExerciseRepositoryInterface $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    public function getAll(): array
    {
        $results = $this->exerciseRepository->all(
            collect([
                'select' => ['id','name', 'exercise_categories_id'],
                'with' => ['category' => function($query){
                    $query->select(['id','name']);
                }]
            ])
        );

        return $this->getSuccessMessage($results);
    }
}

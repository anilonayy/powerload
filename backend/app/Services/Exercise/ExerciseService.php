<?php

namespace App\Services\Exercise;

use App\Repositories\Exercise\ExerciseRepositoryInterface;
use App\Traits\ResponseMessage;
use Illuminate\Database\Eloquent\Collection;

class ExerciseService implements ExerciseServiceInterface
{
    use ResponseMessage;
    protected ExerciseRepositoryInterface $exerciseRepository;
    public function __construct(ExerciseRepositoryInterface $exerciseRepository)
    {
        $this->exerciseRepository = $exerciseRepository;
    }

    /**

     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->exerciseRepository->all();
    }
}

<?php

namespace App\Services\Workout;

use App\Enums\ResponseMessageEnums;
use App\Models\AppModel;
use App\Models\Workout;
use App\Repositories\Workouts\WorkoutRepositoryInterface;
use App\Traits\ResponseMessage;
use Illuminate\Validation\UnauthorizedException;

class WorkoutService implements WorkoutServiceInterface
{
    use ResponseMessage;

    protected WorkoutRepositoryInterface $workoutRepository;
    public function __construct(WorkoutRepositoryInterface $workoutRepository)
    {
        $this->workoutRepository = $workoutRepository;
    }

    /**
     * @param object $payload
     * @return array
     */
    public function create(object $payload): array
    {
        return $this->getSuccessMessage($this->workoutRepository->create($payload));
    }

    /**
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        $workout = $this->workoutRepository->find($id);

        $this->checkOwnerOfModel($workout->user_id);

        return $this->getSuccessMessage($workout);
    }

    /**
     * @param Workout $workout
     * @param object $payload
     * @return array
     */
    public function update(Workout $workout, object $payload): array
    {
        $this->checkOwnerOfModel($workout->user_id);

        return $this->getSuccessMessage($this->workoutRepository->update($workout, $payload));
    }

    /**
     * @param Workout $workout
     * @return array
     */
    public function delete(Workout $workout): array
    {
        $this->checkOwnerOfModel($workout->user_id);

        return $this->getSuccessMessage($this->workoutRepository->delete($workout));
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->getSuccessMessage($this->workoutRepository->all());
    }

    /**
     * @return array
     */
    public function getAllWithDetails(): array
    {
        return $this->getSuccessMessage($this->workoutRepository->allWithDetails());
    }

    private function checkOwnerOfModel(int $ownerId = 0): void
    {
        if($ownerId !== auth()->user()->id) {
            throw new UnauthorizedException(ResponseMessageEnums::FORBIDDEN);
        }
    }
}

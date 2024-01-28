<?php

namespace App\Services\Workout;

use App\Enums\ResponseMessageEnums;
use App\Models\AppModel;
use App\Models\Workout;
use App\Repositories\Workouts\WorkoutRepositoryInterface;
use App\Traits\ResponseMessage;
use Illuminate\Database\Eloquent\Collection;
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
     * @param Workout $payload
     * @return array
     */
    public function create(object $payload): Workout
    {
        return $this->workoutRepository->create($payload);
    }

    /**
     * @param integer $id
     * @return Workout
     */
    public function find(int $id): Workout
    {
        $workout = $this->workoutRepository->find($id);

        $this->checkOwnerOfModel($workout->user_id);

        return $workout;
    }

    /**
     * @param Workout $workout
     * @param object $payload
     * @return Workout
     */
    public function update(Workout $workout, object $payload): Workout
    {
        $this->checkOwnerOfModel($workout->user_id);

        return $this->workoutRepository->update($workout, $payload);
    }

    /**
     * @param Workout $workout
     * @return void
     */
    public function delete(Workout $workout): void
    {
        $this->checkOwnerOfModel($workout->user_id);

        $this->workoutRepository->delete($workout);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->workoutRepository->all();
    }

    /**
     * @return Collection
     */
    public function getAllWithDetails(): Collection
    {
        return $this->workoutRepository->allWithDetails();
    }

    /**
     * @param integer $ownerId
     * @return void
     */
    private function checkOwnerOfModel(int $ownerId = 0): void
    {
        if($ownerId !== auth()->user()->id) {
            throw new UnauthorizedException(ResponseMessageEnums::FORBIDDEN);
        }
    }
}

<?php

namespace App\Services\Training;

use App\Enums\ResponseMessageEnums;
use App\Models\AppModel;
use App\Models\Training;
use App\Repositories\Trainings\TrainingRepositoryInterface;
use App\Traits\ResponseMessage;
use Illuminate\Validation\UnauthorizedException;

class TrainingService implements TrainingServiceInterface
{
    use ResponseMessage;

    protected TrainingRepositoryInterface $trainingRepository;
    public function __construct(TrainingRepositoryInterface $trainingRepository)
    {
        $this->trainingRepository = $trainingRepository;
    }

    /**
     * @param object $payload
     * @return array
     */
    public function create(object $payload): array
    {
        return $this->getSuccessMessage($this->trainingRepository->create($payload));
    }

    /**
     * @param integer $id
     * @return array
     */
    public function find(int $id): array
    {
        $training = $this->trainingRepository->find($id);

        $this->checkOwnerOfModel($training->user_id);

        return $this->getSuccessMessage($training);
    }

    /**
     * @param Training $training
     * @param object $payload
     * @return array
     */
    public function update(Training $training, object $payload): array
    {
        $this->checkOwnerOfModel($training->user_id);

        return $this->getSuccessMessage($this->trainingRepository->update($training, $payload));
    }

    /**
     * @param Training $training
     * @return array
     */
    public function delete(Training $training): array
    {
        $this->checkOwnerOfModel($training->user_id);

        return $this->getSuccessMessage($this->trainingRepository->delete($training));
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->getSuccessMessage($this->trainingRepository->all());
    }

    /**
     * @return array
     */
    public function getAllWithDetails(): array
    {
        return $this->getSuccessMessage($this->trainingRepository->allWithDetails());
    }

    private function checkOwnerOfModel(int $ownerId = 0): void
    {
        if($ownerId !== auth()->user()->id) {
            throw new UnauthorizedException(ResponseMessageEnums::FORBIDDEN);
        }
    }
}

<?php

namespace App\Services\Training;

use App\Models\AppModel;
use App\Models\Training;
use App\Repositories\Trainings\TrainingRepositoryInterface;
use App\Traits\ResponseMessage;

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
        $training = $this->trainingRepository->create([
            'user_id' => auth()->user()->id,
            'name' => $payload->train['name']
        ]);

        $this->addTrainingDaysByPayload($training, (array)$payload);

        return $this->getSuccessMessage($training);
    }

    /**
     * @param Training $training
     * @return array
     */
    public function get(int $id): array
    {
        // to be continue from here
        $training = $this->trainingRepository->findById($id, collect([
            'with' => ['days' => function($query){
            }]
        ]));

        $this->trainingRepository->checkOwnerOfModel($training->user_id);

        return $this->getSuccessMessage($training);
    }

    /**
     * @param Training $training
     * @param object $payload
     * @return array
     */
    public function update(Training $training, object $payload): array
    {
        $this->trainingRepository->checkOwnerOfModel($training->user_id);

        $training->days()->delete();

        $this->addTrainingDaysByPayload($training,(array) $payload);

        return $this->getSuccessMessage($training->days());
    }

    /**
     * @param Training $training
     * @return array
     */
    public function delete(Training $training): array
    {
        $this->trainingRepository->checkOwnerOfModel($training->user_id);

        $training->delete();

        return $this->getSuccessMessage();
    }

    public function getAll(): array
    {
        $results = $this->trainingRepository->all(
            collect([
                'where' => ['user_id' => auth()->user()->id],
                'select' => ['id', 'name','created_at'],
                'withCount' => 'training_logs'
            ])
        );

        return $this->getSuccessMessage($results);
    }

    public function getAllWithDetails(): array
    {
        $results = $this->trainingRepository->all(
            collect([
                'where' => ['user_id' => auth()->user()->id],
                'select' => ['id', 'name'],
                'with' => ['days' => function($query){
                    $query->select(['id', 'name', 'training_id']);
                }]
            ])
        );

        return $this->getSuccessMessage($results);
    }

    /**
     * @param AppModel $training
     * @param array $payload
     * @return void
     */
    public function addTrainingDaysByPayload(AppModel $training, array $payload): void
    {
        foreach($payload['train']['days'] as $day) {
            $trainingDay = $training->days()->create([
                'name' => $day['name']
            ]);

            foreach($day['exercises'] as $exercise) {
                $trainingDay->exercises()->create([
                    'exercise_id' => $exercise['selected']['value'],
                    'sets' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                ]);
            }
        }
    }
}

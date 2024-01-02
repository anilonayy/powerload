<?php

namespace App\Services\Training;

use App\Enums\ResponseMessageEnums;
use App\Models\Training;
use App\Models\TrainingDay;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingService implements TrainingServiceInterface
{
    use ResponseMessage;

    /**
     * @param object $payload
     * @return array
     */
    public function create(object $payload): array
    {
        $training =  Training::create([
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
    public function get(Training $training): array
    {
        $this->checkTrainingOwner($training);

        $training->load([
            'days' => fn($query) =>  $query->with('exercises')
        ]);

        return $this->getSuccessMessage($training);
    }

    /**
     * @param Training $training
     * @param object $payload
     * @return array
     */
    public function update(Training $training, object $payload): array
    {
        $this->checkTrainingOwner($training);

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
        $this->checkTrainingOwner($training);
        $training->delete();

        return $this->getSuccessMessage();
    }

    public function getAll(): array
    {
        return $this->getSuccessMessage(
            Training::where([['user_id', auth()->user()->id]])
            ->without('days')
            ->get(['id','name','created_at'])
        );
    }

    public function getAllWithDetails(): array
    {
        $trainings = Training::with(['days' => function($query) {
            $query->without('exercises');
        }])->where('user_id', auth()->user()->id)->orderBy('id','asc')->get();

        return $this->getSuccessMessage($trainings);
    }


    public function addTrainingDaysByPayload(Training $training, array $payload): void
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

    public function checkTrainingOwner (Training $training): void
    {
        if ($training->user_id !== auth()->user()->id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }

    public function checkTrainingDayOwner (TrainingDay $trainingDay): void
    {
        if ($trainingDay->training->user_id !== auth()->user()->id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

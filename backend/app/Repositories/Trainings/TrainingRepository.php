<?php

namespace App\Repositories\Trainings;

use App\Models\Training;
use Illuminate\Support\Collection;

class TrainingRepository implements TrainingRepositoryInterface
{
    /**
     * @return Collection
     */
    public  function  all(): Collection
    {
        return Training::where([
            ['user_id', auth()->user()->id]
        ])
        ->select(['id', 'name', 'created_at'])
        ->withCount('training_logs')
        ->get();
    }

    /**
     * @return Collection
     */
    public function allWithDetails(): Collection
    {
        return Training::where([
            ['user_id', auth()->user()->id]
        ])
        ->with(['days' => function($query){
            $query->select(['id', 'name', 'training_id']);
        }])
        ->select(['id', 'name', 'created_at'])
        ->get();
    }

    /**
     * @param integer $id
     * @return Training
     */
    public function find(int $id): Training
    {
        return Training::where([
            'id' => $id
        ])
        ->with(['days' => function($query){
            $query->select(['id', 'name', 'training_id']);
            $query->with(['exercises' => function($query) {
                $query->with('exercise:id,name');
            }]);
        }])
        ->select(['id', 'name', 'user_id'])
        ->firstOrFail();
    }

    /**
     * @param Training $training
     * @return void
     */
    public function delete(Training $training): void
    {
        $training->delete();
    }

    /**
     * @param Training $training
     * @param object $payload
     * @return Training
     */
    public function update(Training $training, object $payload): Training
    {
        $training->update([
            'name' => $payload->train['name']
        ]);

        $training->days()->delete();

        $this->addTrainingDaysByPayload($training, $payload);

        return $training;
    }

    /**
     * @param object $payload
     * @return Training
     */
    public function create(object $payload): Training
    {
        $training = Training::create([
            'user_id' => auth()->user()->id,
            'name' => $payload->train['name']
        ]);

        $this->addTrainingDaysByPayload($training, $payload);

        return $training;
    }

    /**
     * @param Training $training
     * @param object $payload
     * @return void
     */
    private function addTrainingDaysByPayload(Training $training, object $payload): void
    {
        foreach($payload->train['days'] as $day) {
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

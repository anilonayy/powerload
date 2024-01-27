<?php

namespace App\Repositories\Workouts;

use App\Models\Workout;
use Illuminate\Support\Collection;

class WorkoutRepository implements WorkoutRepositoryInterface
{
    /**
     * @return Collection
     */
    public  function  all(): Collection
    {
        return Workout::where([
            ['user_id', auth()->user()->id]
        ])
        ->select(['id', 'name', 'created_at'])
        ->withCount('workout_logs')
        ->get();
    }

    /**
     * @return Collection
     */
    public function allWithDetails(): Collection
    {
        return Workout::where([
            ['user_id', auth()->user()->id]
        ])
        ->with(['days' => function($query){
            $query->select(['id', 'name', 'workout_id']);
        }])
        ->select(['id', 'name', 'created_at'])
        ->get();
    }

    /**
     * @param integer $id
     * @return Workout
     */
    public function find(int $id): Workout
    {
        return Workout::where([
            'id' => $id
        ])
        ->with(['days' => function($query){
            $query->select(['id', 'name', 'workout_id']);
            $query->with(['exercises' => function($query) {
                $query->with('exercise:id,name');
            }]);
        }])
        ->select(['id', 'name', 'user_id'])
        ->firstOrFail();
    }

    /**
     * @param Workout $workout
     * @return void
     */
    public function delete(Workout $workout): void
    {
        $workout->delete();
    }

    /**
     * @param Workout $workout
     * @param object $payload
     * @return Workout
     */
    public function update(Workout $workout, object $payload): Workout
    {
        $workout->update([
            'name' => $payload->train['name']
        ]);

        $workout->days()->delete();

        $this->addWorkoutDaysByPayload($workout, $payload);

        return $workout;
    }

    /**
     * @param object $payload
     * @return Workout
     */
    public function create(object $payload): Workout
    {
        $workout = Workout::create([
            'user_id' => auth()->user()->id,
            'name' => $payload->train['name']
        ]);

        $this->addWorkoutDaysByPayload($workout, $payload);

        return $workout;
    }

    /**
     * @param Workout $workout
     * @param object $payload
     * @return void
     */
    private function addWorkoutDaysByPayload(Workout $workout, object $payload): void
    {
        foreach($payload->train['days'] as $day) {
            $workoutDay = $workout->days()->create([
                'name' => $day['name']
            ]);

            foreach($day['exercises'] as $exercise) {
                $workoutDay->exercises()->create([
                    'exercise_id' => $exercise['selected']['value'],
                    'sets' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                ]);
            }
        }
    }
}

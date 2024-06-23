<?php

namespace App\Services\WorkoutDay;

use App\Enums\ResponseMessageEnums;
use App\Models\WorkoutDay;
use App\Traits\ResponseMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutDayService implements WorkoutDayServiceInterface
{
    use ResponseMessage;

    /**
     * @param WorkoutDay $workoutDay
     *
     * @return Collection
     */
    public function showExercisesOfDay(WorkoutDay $workoutDay): Collection
    {
        $this->checkWorkoutDayOwner($workoutDay);

        return $workoutDay->exercises;
    }

    /**
     * @param WorkoutDay $workoutDay
     *
     * @return void
     */
    private function checkWorkoutDayOwner(WorkoutDay $workoutDay): void
    {
        if ($workoutDay->workout->user_id !== auth()->user()->id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

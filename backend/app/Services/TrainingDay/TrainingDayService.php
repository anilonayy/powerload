<?php

namespace App\Services\TrainingDay;

use App\Enums\ResponseMessageEnums;
use App\Models\TrainingDay;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingDayService implements TrainingDayServiceInterface
{
    use ResponseMessage;

    /**
     * @param TrainingDay $trainingDay
     * @return array
     */
    public function showExercisesOfDay(TrainingDay $trainingDay): array
    {
        $this->checkTrainingDayOwner($trainingDay);
        return $this->getSuccessMessage($trainingDay->exercises);
    }


    public function checkTrainingDayOwner (TrainingDay $trainingDay): void
    {
        if ($trainingDay->training->user_id !== auth()->user()->id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

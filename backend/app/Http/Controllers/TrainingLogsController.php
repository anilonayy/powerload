<?php

namespace App\Http\Controllers;

use App\Models\TrainingLogs;
use App\Models\TrainingExerciseLogs;
use Illuminate\Http\JsonResponse;
use App\Enums\ResponseMessageEnums;
use App\Http\Requests\TrainingLog\UpdateLogRequest;
use App\Models\TrainingDay;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingLogsController extends Controller
{
    use ResponseMessage;

    public function show (TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkIsUsersLog($trainingLog);

        $trainingLog->load([
            'training_day' => function($query) {
                $query->without('exercises');
                $query->select('id', 'name');
            }
        ]);

        return response()->json($this->getSuccessMessage($trainingLog));
    }

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $user = auth()->user();

        $lastLog = TrainingLogs::where([
            ['user_id', $user->id],
            ['is_completed', false]
        ])->latest()->first();

        $responseLog = $lastLog ?? TrainingLogs::create([
            'user_id' => $user->id
        ]);

        return response()->json($this->getSuccessMessage($responseLog));
    }

    /**
     * @param UpdateLogRequest $request
     * @param TrainingLogs $trainingLogs
     * @return JsonResponse
     */
    public function update(UpdateLogRequest $request, TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkIsUsersLog($trainingLog);

        $trainingLog->update($request->validated());

        return response()->json($this->getSuccessMessage($trainingLog));
    }

    /**
     * @param string $trainingLogId
     * @return JsonResponse
     */
    public function complete(TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkIsUsersLog($trainingLog);

        $trainingLog->update([
            'is_completed' => true,
            'training_end_time' => now()
        ]);

        return response()->json($this->getSuccessMessage($trainingLog));
    }

    public function last(): JsonResponse
    {
        $lastTrainingLog = TrainingLogs::where([
            ['user_id', auth()->user()->id],
            ['is_completed', false]
        ])->latest()->first();

        if (!$lastTrainingLog) {
            return response()->json($this->getSuccessMessage([]));
        }

        return response()->json($this->getSuccessMessage([
            'id' => $lastTrainingLog->id,
            'training_id' => $lastTrainingLog->training_id,
            'training_day_id' => $lastTrainingLog->training_day_id,
            'exercises' => TrainingExerciseLogs::where('training_log_id', $lastTrainingLog->id)->get()
        ]));
    }

    private function checkIsUsersLog (TrainingLogs $trainingLog): void
    {
        if(auth()->user()->id !== $trainingLog->user_id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

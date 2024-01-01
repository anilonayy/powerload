<?php

namespace App\Http\Controllers;

use App\Enums\TrainingLogEnums;
use App\Http\Resources\TrainingLogs\TrainingLogs as TrainingLogsResource;
use App\Http\Resources\TrainingLogs\TrainingLogWithDetail as TrainingLogsWithDetailResource;
use App\Models\TrainingLogs;
use Illuminate\Http\JsonResponse;
use App\Enums\ResponseMessageEnums;
use App\Http\Requests\TrainingLog\UpdateLogRequest;
use App\Models\TrainingDay;
use App\Models\TrainingExerciseListLogs;
use App\Traits\ResponseMessage;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingLogsController extends Controller
{
    use ResponseMessage;

    /**
     * @param TrainingLogs $trainingLog
     * @return JsonResponse
     */
    public function show(TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkIsUsersLog($trainingLog);

        $trainingLog->load([
            'trainingDay' => function($query) {
                $query->without('exercises');
                $query->select('id', 'name');
            },
            'training' => fn ($query) => $query->withTrashed()
        ]);

        return response()->json($this->getSuccessMessage((TrainingLogsWithDetailResource::make($trainingLog))));
    }

    public function dailyResults(TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkIsUsersLog($trainingLog);

        if($trainingLog->status !== TrainingLogEnums::TRAINING_COMPLETED) {
            return response()->json($this->getFailMessage('Bu antrenman tamamlanmamış veya bırakılmış.'));
        }

        $trainingLog->load([
            'trainingDay' => function($query) {
                $query->without('exercises');
                $query->select('id', 'name');
            },
            'training' => fn ($query) => $query->withTrashed(),
            'trainingList' => fn ($query) => $query->with('exercise')
        ]);

        $trainingLog->duration = Carbon::parse($trainingLog->training_end_time)->shortAbsoluteDiffForHumans($trainingLog->created_at, 2);


        return response()->json($this->getSuccessMessage(TrainingLogsWithDetailResource::make($trainingLog)));
    }

    /**
     * @return JsonResponse
     */
    public function history(): JsonResponse
    {
        $logs = TrainingLogs::where([
            ['user_id', auth()->user()->id],
            ['status', TrainingLogEnums::TRAINING_COMPLETED],
        ])
        ->with([
            'trainingDay' => function($query) {
                $query->select('id', 'name');
            },
            'training' => function($query) {
                $query->withTrashed()
                ->select('name','id');
            }
        ])
        ->get();

        return response()->json($this->getSuccessMessage(TrainingLogsResource::collection($logs)));
    }

    /**
     * @return JsonResponse
     */
    public function store(): JsonResponse
    {
        $user = auth()->user();

        $lastLog = TrainingLogs::where([
            ['user_id', $user->id],
            ['status', TrainingLogEnums::TRAINING_CONTINUE]
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
        $validated = $request->validated();

        if(array_key_exists('training_day_id', $validated) && array_key_exists('is_new',$validated)) {
            TrainingExerciseListLogs::where('training_exercise_log_id', $trainingLog->id)->delete();
            $trainingDayExercises = TrainingDay::find($validated['training_day_id'])->exercises();

            // Antrenman listesindeki egzersizleri, bu antrenman sessionuna ekle.
            $trainingDayExercises->each(function($exercise) use ($trainingLog) {
                TrainingExerciseListLogs::create([
                    'training_exercise_log_id' => $trainingLog->id,
                    'exercise_id' => $exercise->exercise->id,
                    'is_passed' => false
                ]);
            });
        }

        $trainingLog->update($validated);

        return response()->json($this->getSuccessMessage([
            'id' => $trainingLog->id,
            'training_id' => $trainingLog->training_id,
            'training_day_id' => $trainingLog->training_day_id,
            'exercises' => TrainingExerciseListLogs::where('training_exercise_log_id', $trainingLog->id)->get()
        ]));
    }

    /**
     * @param string $trainingLogId
     * @return JsonResponse
     */
    public function complete(TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkIsUsersLog($trainingLog);

        $trainingLog->update([
            'status' => TrainingLogEnums::TRAINING_COMPLETED,
            'training_end_time' => now()
        ]);

        return response()->json($this->getSuccessMessage());
    }

    public function last(): JsonResponse
    {
        $lastTrainingLog = TrainingLogs::where([
            ['user_id', auth()->user()->id],
            ['status', TrainingLogEnums::TRAINING_CONTINUE]
        ])->latest()->first();

        if (!$lastTrainingLog) {
            return response()->json($this->getSuccessMessage([]));
        }

        return response()->json($this->getSuccessMessage([
            'id' => $lastTrainingLog->id,
            'training_id' => $lastTrainingLog->training_id,
            'training_day_id' => $lastTrainingLog->training_day_id,
            'exercises' => TrainingExerciseListLogs::where('training_exercise_log_id', $lastTrainingLog->id)->get()
        ]));
    }

    public function giveUp(TrainingLogs $trainingLog): JsonResponse
    {
        $this->checkIsUsersLog($trainingLog);

        $trainingLog->update([
            'status' => TrainingLogEnums::TRAINING_GIVE_UP,
            'training_end_time' => now()
        ]);

        return response()->json($this->getSuccessMessage($trainingLog));
    }

    private function checkIsUsersLog (TrainingLogs $trainingLog): void
    {
        if(auth()->user()->id !== $trainingLog->user_id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

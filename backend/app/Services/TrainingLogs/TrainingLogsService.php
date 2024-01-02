<?php

namespace App\Services\TrainingLogs;

use App\Enums\TrainingLogEnums;
use App\Http\Resources\TrainingLogs\TrainingLogs as TrainingLogsResource;
use App\Http\Resources\TrainingLogs\TrainingLogWithDetail as TrainingLogsWithDetailResource;
use App\Models\TrainingLogs;
use App\Enums\ResponseMessageEnums;
use App\Models\TrainingDay;
use App\Models\TrainingExerciseListLogs;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingLogsService implements TrainingLogsServiceInterface
{
    use ResponseMessage;

    /**
     * @param TrainingLogs $trainingLog
     * @return array
     */
    public function show(TrainingLogs $trainingLog): array
    {
        $this->checkIsUsersLog($trainingLog->user_id);

        $trainingLog->load([
            'trainingDay' => function($query) {
                $query->without('exercises');
                $query->select('id', 'name');
            },
            'training' => fn ($query) => $query->withTrashed()
        ]);

        return $this->getSuccessMessage((TrainingLogsWithDetailResource::make($trainingLog)));
    }

    public function dailyResults(TrainingLogs $trainingLog): array
    {
        $this->checkIsUsersLog($trainingLog->user_id);

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

        return $this->getSuccessMessage(TrainingLogsWithDetailResource::make($trainingLog));
    }

    /**
     * @return array
     */
    public function index(): array
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

        return $this->getSuccessMessage(TrainingLogsResource::collection($logs));
    }

    /**
     * @return array
     */
    public function store(): array
    {
        $user = auth()->user();

        $lastLog = TrainingLogs::where([
            ['user_id', $user->id],
            ['status', TrainingLogEnums::TRAINING_CONTINUE]
        ])->latest()->first();

        $responseLog = $lastLog ?? TrainingLogs::create([
            'user_id' => $user->id
        ]);

        return $this->getSuccessMessage($responseLog);
    }

    public function update(TrainingLogs $trainingLog, array $payload): array
    {
        $this->checkIsUsersLog($trainingLog->user_id);

        if(array_key_exists('training_day_id', $payload) && array_key_exists('is_new', $payload)) {
            TrainingExerciseListLogs::where('training_exercise_log_id', $trainingLog->id)->delete();
            $trainingDayExercises = TrainingDay::find($payload['training_day_id'])->exercises();

            // Antrenman listesindeki egzersizleri, bu antrenman sessionuna ekle.
            $trainingDayExercises->each(function($exercise) use ($trainingLog) {
                TrainingExerciseListLogs::create([
                    'training_exercise_log_id' => $trainingLog->id,
                    'exercise_id' => $exercise->exercise->id,
                    'is_passed' => false
                ]);
            });
        }

        $trainingLog->update($payload);

        return $this->getSuccessMessage([
            'id' => $trainingLog->id,
            'training_id' => $trainingLog->training_id,
            'training_day_id' => $trainingLog->training_day_id,
            'exercises' => TrainingExerciseListLogs::where('training_exercise_log_id', $trainingLog->id)->get()
        ]);
    }


    public function complete(TrainingLogs $trainingLog): array
    {
        $this->checkIsUsersLog($trainingLog->user_id);

        $trainingLog->update([
            'status' => TrainingLogEnums::TRAINING_COMPLETED,
            'training_end_time' => now()
        ]);

        return $this->getSuccessMessage();
    }

    public function last(): array
    {
        $lastTrainingLog = TrainingLogs::where([
            ['user_id', auth()->user()->id],
            ['status', TrainingLogEnums::TRAINING_CONTINUE]
        ])->latest()->first();

        if (!$lastTrainingLog) {
            return $this->getSuccessMessage([]);
        }

        return $this->getSuccessMessage([
            'id' => $lastTrainingLog->id,
            'training_id' => $lastTrainingLog->training_id,
            'training_day_id' => $lastTrainingLog->training_day_id,
            'exercises' => TrainingExerciseListLogs::where('training_exercise_log_id', $lastTrainingLog->id)->get()
        ]);
    }

    public function giveUp(TrainingLogs $trainingLog): array
    {
        $this->checkIsUsersLog($trainingLog->user_id);

        $trainingLog->update([
            'status' => TrainingLogEnums::TRAINING_GIVE_UP,
            'training_end_time' => now()
        ]);

        return $this->getSuccessMessage($trainingLog);
    }

    private function checkIsUsersLog (int $logOwnerId): void
    {
        if(auth()->user()->id !== $logOwnerId) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

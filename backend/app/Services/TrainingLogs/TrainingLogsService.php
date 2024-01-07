<?php

namespace App\Services\TrainingLogs;

use App\Enums\TrainingLogEnums;
use App\Http\Resources\TrainingLogs\TrainingLogs as TrainingLogsResource;
use App\Http\Resources\TrainingLogs\TrainingLogWithDetail as TrainingLogsWithDetailResource;
use App\Models\TrainingLogs;
use App\Enums\ResponseMessageEnums;
use App\Http\Requests\Request;
use App\Models\TrainingDay;
use App\Models\TrainingExerciseListLogs;
use App\Repositories\TrainingLogs\TrainingLogsRepositoryInterface;
use App\Traits\Helpers\DateHelper;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingLogsService implements TrainingLogsServiceInterface
{
    use ResponseMessage,DateHelper;

    protected TrainingLogsRepositoryInterface $trainingLogsRepository;
    public function __construct(TrainingLogsRepositoryInterface $trainingLogsRepository)
    {
        $this->trainingLogsRepository = $trainingLogsRepository;
    }

    public function show(int $id): array
    {
        $trainingLog = $this->trainingLogsRepository->findWithDetails($id);

        $this->checkIsUsersLog($trainingLog->user_id);

        return $this->getSuccessMessage((TrainingLogsWithDetailResource::make($trainingLog)));
    }

    public function dailyResults(int $id): array
    {
        $trainingLog = $this->trainingLogsRepository->dailyResults($id);

        $this->checkIsUsersLog($trainingLog->user_id);

        if($trainingLog->status !== TrainingLogEnums::TRAINING_COMPLETED) {
            $this->getFailMessage('Bu antrenman tamamlanmamış veya yarıda bırakılmış.');
        }

        return $this->getSuccessMessage(TrainingLogsWithDetailResource::make($trainingLog));
    }

    public function index(array $payload): array
    {
        return $this->getSuccessMessage(TrainingLogsResource::collection($this->trainingLogsRepository->all($payload)));
    }

    public function store(): array
    {
        return $this->getSuccessMessage($this->trainingLogsRepository->lastOrNew());
    }

    public function lastOrNew(): array
    {
        return $this->getSuccessMessage($this->trainingLogsRepository->lastOrNew());
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
            'exercises' => TrainingExerciseListLogs::where('training_exercise_log_id', $trainingLog->id)->with(['exercise' => function($query){
                $query->select(['id', 'name','exercise_categories_id']);
                $query->with(['category' => function($query){
                    $query->select(['id', 'name']);
                }]);
            }])->get()
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

    public function stats(): array
    {
        return $this->getSuccessMessage((object) [
            'training_count' => $this->trainingLogsRepository->getTrainingCounts(),
            'average_training_time' => $this->trainingLogsRepository->getTrainingTimeAverage(),
            'average_exercise_count' => (double)number_format($this->trainingLogsRepository->getTrainingExerciseAverage(), 1),
        ]);
    }

    private function checkIsUsersLog (int $logOwnerId): void
    {
        if(auth()->user()->id !== $logOwnerId) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

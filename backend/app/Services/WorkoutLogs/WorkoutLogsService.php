<?php

namespace App\Services\WorkoutLogs;

use App\Enums\WorkoutLogEnums;
use App\Http\Resources\WorkoutLogs\WorkoutLogs as WorkoutLogsResource;
use App\Http\Resources\WorkoutLogs\WorkoutLogWithDetail as WorkoutLogsWithDetailResource;
use App\Models\WorkoutLogs;
use App\Enums\ResponseMessageEnums;
use App\Http\Requests\Request;
use App\Models\WorkoutDay;
use App\Models\WorkoutExerciseListLogs;
use App\Repositories\WorkoutLogs\WorkoutLogsRepositoryInterface;
use App\Traits\Helpers\DateHelper;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutLogsService implements WorkoutLogsServiceInterface
{
    use ResponseMessage,DateHelper;

    protected WorkoutLogsRepositoryInterface $workoutLogsRepository;
    public function __construct(WorkoutLogsRepositoryInterface $workoutLogsRepository)
    {
        $this->workoutLogsRepository = $workoutLogsRepository;
    }

    public function show(int $id): array
    {
        $workoutLog = $this->workoutLogsRepository->findWithDetails($id);

        $this->checkIsUsersLog($workoutLog->user_id);

        return $this->getSuccessMessage((WorkoutLogsWithDetailResource::make($workoutLog)));
    }

    public function dailyResults(int $id): array
    {
        $workoutLog = $this->workoutLogsRepository->dailyResults($id);

        $this->checkIsUsersLog($workoutLog->user_id);

        if($workoutLog->status !== WorkoutLogEnums::TRAINING_COMPLETED) {
            $this->getFailMessage('Bu antrenman tamamlanmamış veya yarıda bırakılmış.');
        }

        return $this->getSuccessMessage(WorkoutLogsWithDetailResource::make($workoutLog));
    }

    public function index(array $payload): array
    {
        return $this->getSuccessMessage(WorkoutLogsResource::collection($this->workoutLogsRepository->all($payload)));
    }

    public function store(): array
    {
        return $this->getSuccessMessage($this->workoutLogsRepository->lastOrNew());
    }

    public function lastOrNew(): array
    {
        return $this->getSuccessMessage($this->workoutLogsRepository->lastOrNew());
    }

    public function update(WorkoutLogs $workoutLog, array $payload): array
    {
        $this->checkIsUsersLog($workoutLog->user_id);

        if(array_key_exists('workout_day_id', $payload) && array_key_exists('is_new', $payload)) {
            WorkoutExerciseListLogs::where('workout_exercise_log_id', $workoutLog->id)->delete();
            $workoutDayExercises = WorkoutDay::find($payload['workout_day_id'])->exercises();

            // Antrenman listesindeki egzersizleri, bu antrenman sessionuna ekle.
            $workoutDayExercises->each(function($exercise) use ($workoutLog) {
                WorkoutExerciseListLogs::create([
                    'workout_exercise_log_id' => $workoutLog->id,
                    'exercise_id' => $exercise->exercise->id,
                    'is_passed' => false
                ]);
            });
        }

        $workoutLog->update($payload);

        return $this->getSuccessMessage([
            'id' => $workoutLog->id,
            'workout_id' => $workoutLog->workout_id,
            'workout_day_id' => $workoutLog->workout_day_id,
            'exercises' => WorkoutExerciseListLogs::where('workout_exercise_log_id', $workoutLog->id)->with(['exercise' => function($query){
                $query->select(['id', 'name','exercise_categories_id']);
                $query->with(['category' => function($query){
                    $query->select(['id', 'name']);
                }]);
            }])->get()
        ]);
    }


    public function complete(WorkoutLogs $workoutLog): array
    {
        $this->checkIsUsersLog($workoutLog->user_id);

        $workoutLog->update([
            'status' => WorkoutLogEnums::TRAINING_COMPLETED,
            'workout_end_time' => now()
        ]);

        return $this->getSuccessMessage();
    }

    public function last(): array
    {
        $lastWorkoutLog = WorkoutLogs::where([
            ['user_id', auth()->user()->id],
            ['status', WorkoutLogEnums::TRAINING_CONTINUE]
        ])->latest()->first();

        if (!$lastWorkoutLog) {
            return $this->getSuccessMessage([]);
        }

        return $this->getSuccessMessage([
            'id' => $lastWorkoutLog->id,
            'workout_id' => $lastWorkoutLog->workout_id,
            'workout_day_id' => $lastWorkoutLog->workout_day_id,
            'exercises' => WorkoutExerciseListLogs::where('workout_exercise_log_id', $lastWorkoutLog->id)->get()
        ]);
    }

    public function giveUp(WorkoutLogs $workoutLog): array
    {
        $this->checkIsUsersLog($workoutLog->user_id);

        $workoutLog->update([
            'status' => WorkoutLogEnums::TRAINING_GIVE_UP,
            'workout_end_time' => now()
        ]);

        return $this->getSuccessMessage($workoutLog);
    }

    public function stats(): array
    {
        return $this->getSuccessMessage((object) [
            'workout_count' => $this->workoutLogsRepository->getWorkoutCounts(),
            'average_workout_time' => $this->workoutLogsRepository->getWorkoutTimeAverage(),
            'average_exercise_count' => (double)number_format($this->workoutLogsRepository->getWorkoutExerciseAverage(), 1),
        ]);
    }

    public function personalRecords(): array
    {
        return $this->getSuccessMessage($this->workoutLogsRepository->personalRecords());
    }

    public function exerciseHistory(object $payload): array
    {
        return $this->getSuccessMessage($this->workoutLogsRepository->exerciseHistory($payload));
    }

    private function checkIsUsersLog (int $logOwnerId): void
    {
        if(auth()->user()->id !== $logOwnerId) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

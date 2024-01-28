<?php

namespace App\Services\WorkoutLogs;

use App\Enums\WorkoutLogEnums;
use App\Http\Resources\WorkoutLogs\WorkoutLogs as WorkoutLogsResource;
use App\Http\Resources\WorkoutLogs\WorkoutLogWithDetail as WorkoutLogsWithDetailResource;
use App\Models\WorkoutLogs;
use App\Enums\ResponseMessageEnums;
use App\Models\WorkoutDay;
use App\Models\WorkoutExerciseListLogs;
use App\Repositories\WorkoutLogs\WorkoutLogsRepositoryInterface;
use App\Traits\Helpers\DateHelper;
use App\Traits\ResponseMessage;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutLogsService implements WorkoutLogsServiceInterface
{
    use ResponseMessage,DateHelper;

    protected WorkoutLogsRepositoryInterface $workoutLogsRepository;
    public function __construct(WorkoutLogsRepositoryInterface $workoutLogsRepository)
    {
        $this->workoutLogsRepository = $workoutLogsRepository;
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        $workoutLog = $this->workoutLogsRepository->findWithDetails($id);

        $this->checkIsUsersLog($workoutLog->user_id);

        return WorkoutLogsWithDetailResource::make($workoutLog);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function dailyResults(int $id): mixed
    {
        $workoutLog = $this->workoutLogsRepository->dailyResults($id);

        $this->checkIsUsersLog($workoutLog->user_id);

        if($workoutLog->status !== WorkoutLogEnums::WORKOUT_COMPLETED) {
            $this->getFailMessage('Bu antrenman tamamlanmamış veya yarıda bırakılmış.');
        }

        return WorkoutLogsWithDetailResource::make($workoutLog);
    }

    /**
     * @param array $payload
     * @return mixed
     */
    public function index(array $payload): mixed
    {
        return WorkoutLogsResource::collection($this->workoutLogsRepository->all($payload));
    }

    /**
     *
     * @return WorkoutLogs
     */
    public function store(): WorkoutLogs
    {
        return $this->workoutLogsRepository->lastOrNew();
    }

    /**
     *
     * @return WorkoutLogs
     */
    public function lastOrNew(): WorkoutLogs
    {
        return $this->workoutLogsRepository->lastOrNew();
    }

    /**
     * @param WorkoutLogs $workoutLog
     * @param array $payload
     * @return array
     */
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

        return [
            'id' => $workoutLog->id,
            'workout_id' => $workoutLog->workout_id,
            'workout_day_id' => $workoutLog->workout_day_id,
            'exercises' => WorkoutExerciseListLogs::where('workout_exercise_log_id', $workoutLog->id)->with(['exercise' => function($query){
                $query->select(['id', 'name','exercise_categories_id']);
                $query->with(['category' => function($query){
                    $query->select(['id', 'name']);
                }]);
            }])->get()
        ];
    }


    /**
     * @param WorkoutLogs $workoutLog
     * @return void
     */
    public function complete(WorkoutLogs $workoutLog): void
    {
        $this->checkIsUsersLog($workoutLog->user_id);

        $workoutLog->update([
            'status' => WorkoutLogEnums::WORKOUT_COMPLETED,
            'workout_end_time' => now()
        ]);
    }

    /**
     * @return array
     */
    public function last(): array
    {
        $lastWorkoutLog = WorkoutLogs::where([
            ['user_id', auth()->user()->id],
            ['status', WorkoutLogEnums::WORKOUT_CONTINUE]
        ])->latest()->first();

        if (!$lastWorkoutLog) {
            return [];
        }

        return [
            'id' => $lastWorkoutLog->id,
            'workout_id' => $lastWorkoutLog->workout_id,
            'workout_day_id' => $lastWorkoutLog->workout_day_id,
            'exercises' => WorkoutExerciseListLogs::where('workout_exercise_log_id', $lastWorkoutLog->id)->get()
        ];
    }

    /**
     * @param WorkoutLogs $workoutLog
     * @return WorkoutLogs
     */
    public function giveUp(WorkoutLogs $workoutLog): WorkoutLogs
    {
        $this->checkIsUsersLog($workoutLog->user_id);

        $workoutLog->update([
            'status' => WorkoutLogEnums::WORKOUT_GIVE_UP,
            'workout_end_time' => now()
        ]);

        return $workoutLog;
    }

    /**
     * @return array
     */
    public function stats(): array
    {
        return [
            'workout_count' => $this->workoutLogsRepository->getWorkoutCounts(),
            'average_workout_time' => $this->workoutLogsRepository->getWorkoutTimeAverage(),
            'average_exercise_count' => (double)number_format($this->workoutLogsRepository->getWorkoutExerciseAverage(), 1),
        ];
    }

    /**
     * @return Collection
     */
    public function personalRecords(): Collection
    {
        return $this->workoutLogsRepository->personalRecords();
    }

    /**
     * @param object $payload
     * @return Collection
     */
    public function exerciseHistory(object $payload): Collection
    {
        return $this->workoutLogsRepository->exerciseHistory($payload);
    }

    /**
     * @param integer $logOwnerId
     * @return void
     */
    private function checkIsUsersLog (int $logOwnerId): void
    {
        if(auth()->user()->id !== $logOwnerId) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}

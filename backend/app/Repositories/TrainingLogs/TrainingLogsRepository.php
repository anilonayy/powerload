<?php

namespace App\Repositories\TrainingLogs;

use App\Enums\TrainingLogEnums;
use App\Models\TrainingLogs;
use App\Traits\Helpers\DateHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TrainingLogsRepository implements TrainingLogsRepositoryInterface
{
    use DateHelper;
    public function all(array $payload): Collection
    {
        $page = $payload['page'] ?? 0;
        $take = $payload['take'] ?? 10;
        $descBy = $payload['descBy'] ?? 'created_at';

        return TrainingLogs::where([
            ['user_id', auth()->user()->id],
            ['status', TrainingLogEnums::TRAINING_COMPLETED],
        ])
        ->with([
            'trainingDay' => function($query) {
                $query->withTrashed();
                $query->select(['id','name']);
            },
            'training' => function($query) {
                $query->withTrashed()
                ->select(['id', 'name']);
            }
        ])
        ->skip($page * $take)
        ->take($take)
        ->orderByDesc($descBy)
        ->get();
    }

    public function find(int $id): TrainingLogs
    {
        return TrainingLogs::findOrFail($id);
    }

    public function findWithDetails(int $id): TrainingLogs
    {
        return TrainingLogs::where([
            ['id', $id],
            ['user_id', auth()->user()->id],
            ['status', TrainingLogEnums::TRAINING_COMPLETED],
        ])
        ->with([
            'trainingDay' => function($query) {
                $query->withTrashed();
                $query->without('exercises');
                $query->select('id', 'name');
            },
            'training' => fn ($query) => $query->withTrashed(),
            'trainingList' =>  function($query) {
                $query->select(['id', 'training_exercise_log_id', 'exercise_id', 'is_passed']);
                $query->with(['exercise' => function($query) {
                        $query->select(['id', 'name','exercise_categories_id']);
                        $query->with(['category:id,name']);
                    },
                    'exercise_logs:id,weight,reps,training_exercise_list_log_id']);
            }
        ])->first();
    }

    public function dailyResults(int $id): TrainingLogs
    {
        return TrainingLogs::where([
            ['id', $id]
        ])
        ->with([
            'trainingDay' => function($query) {
                $query->without('exercises');
                $query->select('id', 'name');
            },
            'training' => fn ($query) => $query->withTrashed(),
            'trainingList' =>  function($query) {
                $query->select(['id', 'training_exercise_log_id', 'exercise_id', 'is_passed']);
                $query->with(['exercise' => function($query) {
                        $query->select(['id', 'name','exercise_categories_id']);
                        $query->with(['category' => function($query) {
                            $query->select(['id', 'name']);
                        }]);
                    },
                    'exercise_logs' => function($query) {
                        $query->select(['id', 'training_exercise_list_log_id', 'weight', 'reps']);
                    }]);
            }
        ])->first();
    }

    public function create(array $data) : TrainingLogs
    {
        return TrainingLogs::create($data);
    }

    public function lastOrNew(): TrainingLogs
    {
        $user = auth()->user();

        $lastLog = TrainingLogs::where([
            ['user_id', $user->id],
            ['status', TrainingLogEnums::TRAINING_CONTINUE]
        ])->latest()->first();

        return $lastLog ?? TrainingLogs::create([
            'user_id' => $user->id
        ]);
    }

    public function update(array $data): TrainingLogs
    {
        $trainingLogs = TrainingLogs::findOrFail($data['id']);
        $trainingLogs->update($data);
        return $trainingLogs;
    }

    public function delete(int $id): void
    {
        $trainingLogs = TrainingLogs::findOrFail($id);
        $trainingLogs->delete();
    }

    public function getTrainingCounts(): int
    {
        return TrainingLogs::where([
            ['status', TrainingLogEnums::TRAINING_COMPLETED],
            ['user_id', auth()->user()->id]
        ])
        ->count();
    }

    public function getTrainingExerciseAverage(): float
    {
        $userId = auth()->user()->id;

        return  TrainingLogs::selectRaw('AVG(subquery.exerciseCount) as averageExerciseCount')
        ->from(DB::raw("(SELECT tell.training_exercise_log_id, COUNT(*) as exerciseCount
            FROM training_exercise_list_logs tell
            LEFT JOIN training_logs  tl ON tl.id = tell.training_exercise_log_id
            WHERE is_passed = 0 AND tl.user_id = {$userId}
            GROUP BY tell.training_exercise_log_id) as subquery"))
        ->first()->averageExerciseCount;
    }

    public function getTrainingTimeAverage(): string
    {
        $userId = auth()->user()->id;

        $trainingTime = TrainingLogs::where([
            ['status', TrainingLogEnums::TRAINING_COMPLETED],
            ['user_id', $userId]
        ])
        ->select(DB::raw('avg(UNIX_TIMESTAMP(training_end_time) - UNIX_TIMESTAMP(created_at)) as averageTime'))
        ->first();

        return !is_null($trainingTime->averageTime)
            ? $this->calculateDurationForHumans(strtotime(now()), (strtotime(now()) + $trainingTime->averageTime))
            : '0';

    }
}

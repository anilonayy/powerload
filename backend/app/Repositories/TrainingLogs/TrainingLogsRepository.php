<?php

namespace App\Repositories\TrainingLogs;

use App\Enums\TrainingLogEnums;
use App\Models\TrainingLogs;
use Illuminate\Support\Collection;

class TrainingLogsRepository implements TrainingLogsRepositoryInterface
{
    public function all(): Collection
    {
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
}

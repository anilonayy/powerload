<?php

namespace App\Repositories\TrainingLogs;

use App\Enums\DateEnums;
use App\Enums\TrainingListLogEnums;
use App\Enums\TrainingLogEnums;
use App\Models\TrainingExerciseListLogs;
use App\Models\TrainingExerciseLogs;
use App\Models\TrainingLogs;
use App\Traits\Helpers\DateHelper;
use Carbon\Carbon;
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
                'trainingDay' => function ($query) {
                    $query->withTrashed();
                    $query->select(['id', 'name']);
                },
                'training' => function ($query) {
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
                'trainingDay' => function ($query) {
                    $query->withTrashed();
                    $query->without('exercises');
                    $query->select('id', 'name');
                },
                'training' => fn ($query) => $query->withTrashed(),
                'trainingList' =>  function ($query) {
                    $query->select(['id', 'training_exercise_log_id', 'exercise_id', 'is_passed']);
                    $query->with([
                        'exercise' => function ($query) {
                            $query->select(['id', 'name', 'exercise_categories_id']);
                            $query->with(['category:id,name']);
                        },
                        'exercise_logs:id,weight,reps,training_exercise_list_log_id'
                    ]);
                }
            ])->first();
    }

    public function dailyResults(int $id): TrainingLogs
    {
        return TrainingLogs::where([
            ['id', $id]
        ])
            ->with([
                'trainingDay' => function ($query) {
                    $query->without('exercises');
                    $query->select('id', 'name');
                },
                'training' => fn ($query) => $query->withTrashed(),
                'trainingList' =>  function ($query) {
                    $query->select(['id', 'training_exercise_log_id', 'exercise_id', 'is_passed']);
                    $query->with([
                        'exercise' => function ($query) {
                            $query->select(['id', 'name', 'exercise_categories_id']);
                            $query->with(['category' => function ($query) {
                                $query->select(['id', 'name']);
                            }]);
                        },
                        'exercise_logs' => function ($query) {
                            $query->select(['id', 'training_exercise_list_log_id', 'weight', 'reps']);
                        }
                    ]);
                }
            ])->first();
    }

    public function create(array $data): TrainingLogs
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

    public function getTrainingExerciseAverage(): float|null
    {
        $userId = auth()->user()->id;

        return TrainingLogs::selectRaw('AVG(subquery.exerciseCount) as averageExerciseCount')
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

    public function personalRecords(): Collection
    {
        $userId = auth()->user()->id;

        return collect(DB::select("SELECT
            training_id,
            training_end_time,
            training_exercise_list_log_id,
            exercise_id,
            exercise_name,
            category_name,
            max,
            created_at,
            email,
            rowNum
        FROM (
            SELECT
                tl.id as training_id,
                tl.training_end_time as training_end_time,
                training_exercise_list_log_id,
                exercise_id,
                exercise_name,
                category_name,
                max,
                created_at,
                email,
                ROW_NUMBER() OVER (PARTITION BY exercise_id ORDER BY max DESC) AS rowNum
            FROM (
                SELECT
                    tel.training_exercise_list_log_id,
                    e.id AS exercise_id,
                    e.name AS exercise_name,
                    ec.name AS category_name,
                    MAX(tel.weight) AS max
                FROM training_exercise_logs tel
                LEFT JOIN training_exercise_list_logs tell ON tell.id = tel.training_exercise_list_log_id
                LEFT JOIN exercises e ON e.id = tell.exercise_id
                LEFT JOIN exercise_categories ec ON ec.id = e.exercise_categories_id
                GROUP BY tel.training_exercise_list_log_id
            ) AS subquery
            LEFT JOIN (
                SELECT id, training_exercise_log_id, created_at, is_passed
                FROM training_exercise_list_logs
            ) tell ON tell.id = subquery.training_exercise_list_log_id
            LEFT JOIN (
                SELECT id, user_id, training_end_time, status
                FROM training_logs
            ) tl ON tl.id = tell.training_exercise_log_id
            LEFT JOIN (
                SELECT id, email
                FROM users
            ) u ON tl.user_id = u.id
            WHERE tell.is_passed = :is_passed AND tl.status = :status AND u.id = :user_id
        ) AS numberedResults
        WHERE rowNum = :row_num
        ORDER BY rowNum ASC;
        ", [
            'user_id' => $userId,
            'status' => TrainingLogEnums::TRAINING_COMPLETED,
            'is_passed' => TrainingListLogEnums::NOT_PASSED,
            'row_num' => 1
        ]));
    }

    public function exerciseHistory(object $payload): Collection
    {
        $response = collect([]);
        $userId = auth()->user()->id;
        $currentYear = now()->year;

        $baseSql = "SELECT training_exercise_list_log_id,exercise_id,exercise_name, max, tell.created_at,u.email FROM
        (SELECT tel.training_exercise_list_log_id,e.id as exercise_id,e.name as exercise_name,ec.name as category_name ,max(tel.weight) as max
            FROM training_exercise_logs tel
            LEFT JOIN training_exercise_list_logs tell ON tell.id = tel.training_exercise_list_log_id
            LEFT JOIN exercises e ON e.id = tell.exercise_id
            LEFT JOIN exercise_categories ec ON ec.id = e.exercise_categories_id
            WHERE e.id = :exercise_id
            GROUP BY tel.training_exercise_list_log_id ) as subquery
        LEFT JOIN (select id,training_exercise_log_id, created_at, is_passed from training_exercise_list_logs) tell ON tell.id = subquery.training_exercise_list_log_id
        LEFT JOIN (select id,user_id,training_end_time,status from training_logs) tl ON tl.id = tell.training_exercise_log_id
        LEFT JOIN (select id, email from users) u ON tl.user_id = u.id
        WHERE tell.is_passed = :is_passed AND tl.status = :status  AND u.id = :user_id";
        $baseVariables = [
            'exercise_id' => $payload->exercise_id,
            'status' => TrainingLogEnums::TRAINING_COMPLETED,
            'user_id' => $userId,
            'is_passed' => TrainingListLogEnums::NOT_PASSED
        ];

        $endSql = "ORDER BY max DESC";


        if($payload->date_frequency === DateEnums::YEARLY_DATE_FREQUENCY)
        {
            $targetYear = Carbon::parse(now())->setYears($currentYear - DateEnums::YEARLY_DATE_FREQUENCY_COUNT)->format('Y');

            foreach(range($targetYear, $currentYear) as $year)
            {
                $response->push([
                    'data' => collect((DB::select($baseSql . " AND YEAR(tell.created_at) = :year {$endSql}", [
                        ...$baseVariables,
                        'year' => $year
                    ])))->first() ?? (object) [],
                    'label' => $year
                ]);
            }
        } else if($payload->date_frequency === DateEnums::MONTHLY_DATE_FREQUENCY) {
            foreach(DateEnums::MONTHS_AS_NUMBER as $month)
            {
                $response->push([
                    'data' => collect((DB::select($baseSql . " AND MONTH(tell.created_at) = :month AND YEAR(tell.created_at) = :year {$endSql}", [
                        ...$baseVariables,
                        'month' => $month,
                        'year' => $currentYear
                    ])))->first() ?? (object)[],
                    'label' => DateEnums::MONTHS_AS_NAME["tr_TR"][$month - 1]
                ]);
            }
        } else if($payload->date_frequency === DateEnums::WEEKLY_DATE_FREQUENCY) {
            foreach(range(DateEnums::WEEKLY_DATE_FREQUENCY_COUNT, 0) as $weekNumber)
            {
                $currentWeek = Carbon::parse(now())->week(now()->week - $weekNumber)->format(DateEnums::MYSQL_DATE_FORMAT);

                $response->push([
                    'data' => collect((DB::select($baseSql . " AND YEAR(tell.created_at) = :year AND WEEK(tell.created_at) = WEEK(:week) {$endSql}", [
                        ...$baseVariables,
                        'year' => $currentYear,
                        'week' => $currentWeek
                    ])))->first() ?? (object)[],
                    'label' => $weekNumber === 0 ? 'Bu hafta.' : "{$weekNumber} hafta önce."
                ]);
            }
        }

        return $response;
    }
}

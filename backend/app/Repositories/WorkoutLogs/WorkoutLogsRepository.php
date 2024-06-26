<?php

namespace App\Repositories\WorkoutLogs;

use App\Enums\DateEnums;
use App\Enums\WorkoutListLogEnums;
use App\Enums\WorkoutLogEnums;
use App\Models\WorkoutLogs;
use App\Traits\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorkoutLogsRepository implements WorkoutLogsRepositoryInterface
{
    use DateHelper;

    /**
     * @param array $payload
     *
     * @return mixed
     */
    public function all(array $payload): mixed
    {
        return WorkoutLogs::where([
            ['user_id', auth()->user()->id],
            ['status', WorkoutLogEnums::WORKOUT_COMPLETED],
        ])
        ->with([
            'workoutDay' => function ($query) {
                $query->withTrashed()->select(['id', 'name']);
            },
            'workout' => function ($query) {
                $query->withTrashed()->select(['id', 'name']);
            },
        ])
        ->when($payload['take'] ?? false, function ($query) use ($payload) {
            $query->take($payload['take']);
        })
        ->when($payload['orderBy'] ?? false, function ($query) use ($payload) {
            $query->orderBy($payload['orderBy'], 'desc');
        })
        ->get();
    }

    /**
     * @param array $payload
     *
     * @return mixed
     */
    public function paginate(array $payload): mixed
    {
        $take = $payload['take'] ?? 10;
        $descBy = $payload['descBy'] ?? 'id';

        return WorkoutLogs::where([
            ['user_id', auth()->user()->id],
            ['status', WorkoutLogEnums::WORKOUT_COMPLETED],
        ])
            ->with([
                'workoutDay' => function ($query) {
                    $query->withTrashed()->select(['id', 'name']);
                },
                'workout' => function ($query) {
                    $query->withTrashed()->select(['id', 'name']);
                },
            ])
            ->orderBy($descBy, 'desc')->paginate($take)
            ->toArray();
    }

    /**
     * @param int $id
     *
     * @return WorkoutLogs
     */
    public function find(int $id): WorkoutLogs
    {
        return WorkoutLogs::findOrFail($id);
    }

    /**
     * @param int $id
     *
     * @return WorkoutLogs
     */
    public function findWithDetails(int $id): WorkoutLogs
    {
        return WorkoutLogs::where([
            ['id', $id],
            ['user_id', auth()->user()->id],
            ['status', WorkoutLogEnums::WORKOUT_COMPLETED],
        ])
            ->with([
                'workoutDay' => function ($query) {
                    $query->withTrashed();
                    $query->without('exercises');
                    $query->select('id', 'name');
                },
                'workout' => fn ($query) => $query->withTrashed(),
                'workoutList' => function ($query) {
                    $query->select(['id', 'workout_exercise_log_id', 'exercise_id', 'is_passed']);
                    $query->with([
                        'exercise' => function ($query) {
                            $query->select(['id', 'name', 'exercise_categories_id']);
                            $query->with(['category:id,name']);
                        },
                        'exercise_logs:id,weight,reps,workout_exercise_list_log_id',
                    ]);
                },
            ])->first();
    }

    /**
     * @param int $id
     *
     * @return WorkoutLogs
     */
    public function dailyResults(int $id): WorkoutLogs
    {
        return WorkoutLogs::where([
            ['id', $id],
        ])
            ->with([
                'workoutDay' => function ($query) {
                    $query->without('exercises');
                    $query->select('id', 'name');
                },
                'workout' => fn ($query) => $query->withTrashed(),
                'workoutList' => function ($query) {
                    $query->select(['id', 'workout_exercise_log_id', 'exercise_id', 'is_passed']);
                    $query->with([
                        'exercise' => function ($query) {
                            $query->select(['id', 'name', 'exercise_categories_id']);
                            $query->with(['category' => function ($query) {
                                $query->select(['id', 'name']);
                            }]);
                        },
                        'exercise_logs' => function ($query) {
                            $query->select(['id', 'workout_exercise_list_log_id', 'weight', 'reps']);
                        },
                    ]);
                },
            ])->first();
    }

    /**
     * @param array $data
     *
     * @return WorkoutLogs
     */
    public function create(array $data): WorkoutLogs
    {
        return WorkoutLogs::create($data);
    }

    /**
     * @return WorkoutLogs
     */
    public function lastOrNew(): WorkoutLogs
    {
        $user = auth()->user();

        $lastLog = WorkoutLogs::where([
            ['user_id', $user->id],
            ['status', WorkoutLogEnums::WORKOUT_CONTINUE],
        ])->latest()->first();

        return $lastLog ?? WorkoutLogs::create([
            'user_id' => $user->id,
        ]);
    }

    /**
     * @param array $data
     *
     * @return WorkoutLogs
     */
    public function update(array $data): WorkoutLogs
    {
        $workoutLogs = WorkoutLogs::findOrFail($data['id']);
        $workoutLogs->update($data);

        return $workoutLogs;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function delete(int $id): void
    {
        $workoutLogs = WorkoutLogs::findOrFail($id);
        $workoutLogs->delete();
    }

    /**
     * @return int
     */
    public function getWorkoutCounts(): int
    {
        return WorkoutLogs::where([
            ['status', WorkoutLogEnums::WORKOUT_COMPLETED],
            ['user_id', auth()->user()->id],
        ])
            ->count();
    }

    /**
     * @return float|null
     */
    public function getWorkoutExerciseAverage(): float|null
    {
        $userId = auth()->user()->id;

        return WorkoutLogs::selectRaw('AVG(subquery.exerciseCount) as averageExerciseCount')
            ->from(DB::raw("(SELECT tell.workout_exercise_log_id, COUNT(*) as exerciseCount
            FROM workout_exercise_list_logs tell
            LEFT JOIN workout_logs  tl ON tl.id = tell.workout_exercise_log_id
            WHERE is_passed = 0 AND tl.user_id = {$userId}
            GROUP BY tell.workout_exercise_log_id) as subquery"))
            ->first()->averageExerciseCount;
    }

    /**
     * @return int
     */
    public function getWorkoutTimeAverage(): int
    {
        $userId = auth()->user()->id;

        $workoutTime = WorkoutLogs::where([
            ['status', WorkoutLogEnums::WORKOUT_COMPLETED],
            ['user_id', $userId],
        ])
            ->select(DB::raw('avg(UNIX_TIMESTAMP(workout_end_time) - UNIX_TIMESTAMP(created_at)) as averageTime'))
            ->first();

        return $workoutTime->averageTime ?? 0;
    }

    /**
     * @return Collection
     */
    public function personalRecords(): Collection
    {
        $userId = auth()->user()->id;

        return collect(DB::select('SELECT
            workout_id,
            workout_end_time,
            workout_exercise_list_log_id,
            exercise_id,
            exercise_name,
            category_name,
            max,
            created_at,
            email,
            rowNum
        FROM (
            SELECT
                tl.id as workout_id,
                tl.workout_end_time as workout_end_time,
                workout_exercise_list_log_id,
                exercise_id,
                exercise_name,
                category_name,
                max,
                created_at,
                email,
                ROW_NUMBER() OVER (PARTITION BY exercise_id ORDER BY max DESC) AS rowNum
            FROM (
                SELECT
                    tel.workout_exercise_list_log_id,
                    e.id AS exercise_id,
                    e.name AS exercise_name,
                    ec.name AS category_name,
                    MAX(tel.weight) AS max
                FROM workout_exercise_logs tel
                LEFT JOIN workout_exercise_list_logs tell ON tell.id = tel.workout_exercise_list_log_id
                LEFT JOIN exercises e ON e.id = tell.exercise_id
                LEFT JOIN exercise_categories ec ON ec.id = e.exercise_categories_id
                GROUP BY tel.workout_exercise_list_log_id
            ) AS subquery
            LEFT JOIN (
                SELECT id, workout_exercise_log_id, created_at, is_passed
                FROM workout_exercise_list_logs
            ) tell ON tell.id = subquery.workout_exercise_list_log_id
            LEFT JOIN (
                SELECT id, user_id, workout_end_time, status
                FROM workout_logs
            ) tl ON tl.id = tell.workout_exercise_log_id
            LEFT JOIN (
                SELECT id, email
                FROM users
            ) u ON tl.user_id = u.id
            WHERE tell.is_passed = :is_passed AND tl.status = :status AND u.id = :user_id
        ) AS numberedResults
        WHERE rowNum = :row_num
        ORDER BY rowNum ASC;
        ', [
            'user_id' => $userId,
            'status' => WorkoutLogEnums::WORKOUT_COMPLETED,
            'is_passed' => WorkoutListLogEnums::NOT_PASSED,
            'row_num' => 1,
        ]) ?? []);
    }

    /**
     * @param object $payload
     *
     * @return Collection
     */
    public function exerciseHistory(object $payload): Collection
    {
        $response = collect([]);
        $userId = auth()->user()->id;
        $currentYear = now()->year;

        $baseSql = 'SELECT workout_exercise_list_log_id,exercise_id,exercise_name, max, tell.created_at,u.email FROM
        (SELECT tel.workout_exercise_list_log_id,e.id as exercise_id,e.name as exercise_name,ec.name as category_name ,max(tel.weight) as max
            FROM workout_exercise_logs tel
            LEFT JOIN workout_exercise_list_logs tell ON tell.id = tel.workout_exercise_list_log_id
            LEFT JOIN exercises e ON e.id = tell.exercise_id
            LEFT JOIN exercise_categories ec ON ec.id = e.exercise_categories_id
            WHERE e.id = :exercise_id
            GROUP BY tel.workout_exercise_list_log_id ) as subquery
        LEFT JOIN (select id,workout_exercise_log_id, created_at, is_passed from workout_exercise_list_logs) tell ON tell.id = subquery.workout_exercise_list_log_id
        LEFT JOIN (select id,user_id,workout_end_time,status from workout_logs) tl ON tl.id = tell.workout_exercise_log_id
        LEFT JOIN (select id, email from users) u ON tl.user_id = u.id
        WHERE tell.is_passed = :is_passed AND tl.status = :status  AND u.id = :user_id';
        $baseVariables = [
            'exercise_id' => $payload->exercise_id,
            'status' => WorkoutLogEnums::WORKOUT_COMPLETED,
            'user_id' => $userId,
            'is_passed' => WorkoutListLogEnums::NOT_PASSED,
        ];

        $endSql = 'ORDER BY max DESC';

        if ($payload->date_frequency === DateEnums::YEARLY_DATE_FREQUENCY) {
            $targetYear = Carbon::parse(now())->setYears($currentYear - DateEnums::YEARLY_DATE_FREQUENCY_COUNT)->format('Y');

            foreach (range($targetYear, $currentYear) as $year) {
                $response->push([
                    'data' => collect(DB::select($baseSql . " AND YEAR(tell.created_at) = :year {$endSql}", [
                        ...$baseVariables,
                        'year' => $year,
                    ]))->first() ?? (object) [],
                    'label' => $year,
                ]);
            }
        } elseif ($payload->date_frequency === DateEnums::MONTHLY_DATE_FREQUENCY) {
            foreach (DateEnums::MONTHS_AS_NUMBER as $month) {
                $response->push([
                    'data' => collect(DB::select($baseSql . " AND MONTH(tell.created_at) = :month AND YEAR(tell.created_at) = :year {$endSql}", [
                        ...$baseVariables,
                        'month' => $month,
                        'year' => $currentYear,
                    ]))->first() ?? (object) [],
                    'label' => DateEnums::MONTHS_AS_NAME['tr_TR'][$month - 1],
                ]);
            }
        } elseif ($payload->date_frequency === DateEnums::WEEKLY_DATE_FREQUENCY) {
            foreach (range(DateEnums::WEEKLY_DATE_FREQUENCY_COUNT, 0) as $weekNumber) {
                $currentWeek = Carbon::parse(now())->week(now()->week - $weekNumber)->format(DateEnums::MYSQL_DATE_FORMAT);

                $response->push([
                    'data' => collect(DB::select($baseSql . " AND YEAR(tell.created_at) = :year AND WEEK(tell.created_at) = WEEK(:week) {$endSql}", [
                        ...$baseVariables,
                        'year' => $currentYear,
                        'week' => $currentWeek,
                    ]))->first() ?? (object) [],
                    'label' => $weekNumber === 0 ? 'Bu hafta.' : "{$weekNumber} hafta önce.",
                ]);
            }
        }

        return $response;
    }
}

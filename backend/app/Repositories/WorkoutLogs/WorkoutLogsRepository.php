<?php

namespace App\Repositories\WorkoutLogs;

use App\Enums\DateEnums;
use App\Enums\WorkoutListLogEnums;
use App\Enums\WorkoutLogEnums;
use App\Models\WorkoutExerciseListLogs;
use App\Models\WorkoutExerciseLogs;
use App\Models\WorkoutLogs;
use App\Traits\Helpers\DateHelper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WorkoutLogsRepository implements WorkoutLogsRepositoryInterface
{
    use DateHelper;
    public function all(array $payload): Collection
    {
        $page = $payload['page'] ?? 0;
        $take = $payload['take'] ?? 10;
        $descBy = $payload['descBy'] ?? 'created_at';

        return WorkoutLogs::where([
            ['user_id', auth()->user()->id],
            ['status', WorkoutLogEnums::TRAINING_COMPLETED],
        ])
            ->with([
                'workoutDay' => function ($query) {
                    $query->withTrashed();
                    $query->select(['id', 'name']);
                },
                'workout' => function ($query) {
                    $query->withTrashed()
                        ->select(['id', 'name']);
                }
            ])
            ->skip($page * $take)
            ->take($take)
            ->orderByDesc($descBy)
            ->get();
    }

    public function find(int $id): WorkoutLogs
    {
        return WorkoutLogs::findOrFail($id);
    }

    public function findWithDetails(int $id): WorkoutLogs
    {
        return WorkoutLogs::where([
            ['id', $id],
            ['user_id', auth()->user()->id],
            ['status', WorkoutLogEnums::TRAINING_COMPLETED],
        ])
            ->with([
                'workoutDay' => function ($query) {
                    $query->withTrashed();
                    $query->without('exercises');
                    $query->select('id', 'name');
                },
                'workout' => fn ($query) => $query->withTrashed(),
                'workoutList' =>  function ($query) {
                    $query->select(['id', 'workout_exercise_log_id', 'exercise_id', 'is_passed']);
                    $query->with([
                        'exercise' => function ($query) {
                            $query->select(['id', 'name', 'exercise_categories_id']);
                            $query->with(['category:id,name']);
                        },
                        'exercise_logs:id,weight,reps,workout_exercise_list_log_id'
                    ]);
                }
            ])->first();
    }

    public function dailyResults(int $id): WorkoutLogs
    {
        return WorkoutLogs::where([
            ['id', $id]
        ])
            ->with([
                'workoutDay' => function ($query) {
                    $query->without('exercises');
                    $query->select('id', 'name');
                },
                'workout' => fn ($query) => $query->withTrashed(),
                'workoutList' =>  function ($query) {
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
                        }
                    ]);
                }
            ])->first();
    }

    public function create(array $data): WorkoutLogs
    {
        return WorkoutLogs::create($data);
    }

    public function lastOrNew(): WorkoutLogs
    {
        $user = auth()->user();

        $lastLog = WorkoutLogs::where([
            ['user_id', $user->id],
            ['status', WorkoutLogEnums::TRAINING_CONTINUE]
        ])->latest()->first();

        return $lastLog ?? WorkoutLogs::create([
            'user_id' => $user->id
        ]);
    }

    public function update(array $data): WorkoutLogs
    {
        $workoutLogs = WorkoutLogs::findOrFail($data['id']);
        $workoutLogs->update($data);
        return $workoutLogs;
    }

    public function delete(int $id): void
    {
        $workoutLogs = WorkoutLogs::findOrFail($id);
        $workoutLogs->delete();
    }

    public function getWorkoutCounts(): int
    {
        return WorkoutLogs::where([
            ['status', WorkoutLogEnums::TRAINING_COMPLETED],
            ['user_id', auth()->user()->id]
        ])
            ->count();
    }

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

    public function getWorkoutTimeAverage(): string
    {
        $userId = auth()->user()->id;

        $workoutTime = WorkoutLogs::where([
            ['status', WorkoutLogEnums::TRAINING_COMPLETED],
            ['user_id', $userId]
        ])
            ->select(DB::raw('avg(UNIX_TIMESTAMP(workout_end_time) - UNIX_TIMESTAMP(created_at)) as averageTime'))
            ->first();

        return !is_null($workoutTime->averageTime)
            ? $this->calculateDurationForHumans(strtotime(now()), (strtotime(now()) + $workoutTime->averageTime))
            : '0';
    }

    public function personalRecords(): Collection
    {
        $userId = auth()->user()->id;

        return collect(DB::select("SELECT
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
        ", [
            'user_id' => $userId,
            'status' => WorkoutLogEnums::TRAINING_COMPLETED,
            'is_passed' => WorkoutListLogEnums::NOT_PASSED,
            'row_num' => 1
        ]));
    }

    public function exerciseHistory(object $payload): Collection
    {
        $response = collect([]);
        $userId = auth()->user()->id;
        $currentYear = now()->year;

        $baseSql = "SELECT workout_exercise_list_log_id,exercise_id,exercise_name, max, tell.created_at,u.email FROM
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
        WHERE tell.is_passed = :is_passed AND tl.status = :status  AND u.id = :user_id";
        $baseVariables = [
            'exercise_id' => $payload->exercise_id,
            'status' => WorkoutLogEnums::TRAINING_COMPLETED,
            'user_id' => $userId,
            'is_passed' => WorkoutListLogEnums::NOT_PASSED
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

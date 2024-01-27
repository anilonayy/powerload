<?php

namespace App\Providers;

use App\Models\AppModel;
use App\Repositories\Exercise\ExerciseRepository;
use App\Repositories\Exercise\ExerciseRepositoryInterface;
use App\Repositories\General\GeneralRepositoryInterface;
use App\Repositories\General\GeneralRepository;
use App\Repositories\WorkoutLogs\WorkoutLogsRepository;
use App\Repositories\WorkoutLogs\WorkoutLogsRepositoryInterface;
use App\Repositories\Workouts\WorkoutRepository;
use App\Repositories\Workouts\WorkoutRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GeneralRepositoryInterface::class, GeneralRepository::class);
        $this->app->bind(Model::class, AppModel::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ExerciseRepositoryInterface::class, ExerciseRepository::class);
        $this->app->bind(WorkoutRepositoryInterface::class, WorkoutRepository::class);
        $this->app->bind(WorkoutLogsRepositoryInterface::class, WorkoutLogsRepository::class);
    }
}

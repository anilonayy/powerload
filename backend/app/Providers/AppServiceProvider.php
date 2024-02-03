<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Exercise\ExerciseService;
use App\Services\Exercise\ExerciseServiceInterface;
use App\Services\Workout\WorkoutService;
use App\Services\Workout\WorkoutServiceInterface;
use App\Services\WorkoutDay\WorkoutDayService;
use App\Services\WorkoutDay\WorkoutDayServiceInterface;
use App\Services\WorkoutExerciseLog\WorkoutExerciseLogService;
use App\Services\WorkoutExerciseLog\WorkoutExerciseLogServiceInterface;
use App\Services\WorkoutLogs\WorkoutLogsService;
use App\Services\WorkoutLogs\WorkoutLogsServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(WorkoutServiceInterface::class, WorkoutService::class);
        $this->app->bind(WorkoutDayServiceInterface::class, WorkoutDayService::class);
        $this->app->bind(ExerciseServiceInterface::class, ExerciseService::class);
        $this->app->bind(WorkoutLogsServiceInterface::class, WorkoutLogsService::class);
        $this->app->bind(WorkoutExerciseLogServiceInterface::class, WorkoutExerciseLogService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        JsonResource::withoutWrapping();
    }
}

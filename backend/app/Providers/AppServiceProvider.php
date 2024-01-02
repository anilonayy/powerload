<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\AuthServiceInterface;
use App\Services\Exercise\ExerciseService;
use App\Services\Exercise\ExerciseServiceInterface;
use App\Services\Training\TrainingService;
use App\Services\Training\TrainingServiceInterface;
use App\Services\TrainingDay\TrainingDayService;
use App\Services\TrainingDay\TrainingDayServiceInterface;
use App\Services\TrainingLogs\TrainingLogsService;
use App\Services\TrainingLogs\TrainingLogsServiceInterface;
use App\Services\User\UserService;
use App\Services\User\UserServiceInterface;
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
        $this->app->bind(TrainingServiceInterface::class, TrainingService::class);
        $this->app->bind(TrainingDayServiceInterface::class, TrainingDayService::class);
        $this->app->bind(ExerciseServiceInterface::class, ExerciseService::class);
        $this->app->bind(TrainingLogsServiceInterface::class, TrainingLogsService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = 'tr';
        app()->setLocale($locale);
    }
}

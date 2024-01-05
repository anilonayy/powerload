<?php

namespace App\Providers;

use App\Models\AppModel;
use App\Models\Training;
use App\Models\User;
use App\Repositories\Exercise\ExerciseRepository;
use App\Repositories\Exercise\ExerciseRepositoryInterface;
use App\Repositories\General\GeneralRepositoryInterface;
use App\Repositories\General\GeneralRepository;
use App\Repositories\TrainingLogs\TrainingLogsRepository;
use App\Repositories\TrainingLogs\TrainingLogsRepositoryInterface;
use App\Repositories\Trainings\TrainingRepository;
use App\Repositories\Trainings\TrainingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(GeneralRepositoryInterface::class, GeneralRepository::class);
        $this->app->bind(Model::class, AppModel::class);

        $this->app->bind(ExerciseRepositoryInterface::class, ExerciseRepository::class);
        $this->app->bind(TrainingRepositoryInterface::class, TrainingRepository::class);
        $this->app->bind(TrainingLogsRepositoryInterface::class, TrainingLogsRepository::class);


    }
}

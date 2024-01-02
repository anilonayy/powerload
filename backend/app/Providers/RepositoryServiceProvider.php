<?php

namespace App\Providers;

use App\Models\AppModel;
use App\Models\User;
use App\Repositories\General\GeneralRepositoryInterface;
use App\Repositories\General\GeneralRepository;
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

        $this->app->bind(UserRepositoryInterface::class, function($app) {
            return new UserRepository($app->make(GeneralRepositoryInterface::class), $app->make(User::class));
        });
    }
}

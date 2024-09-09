<?php

namespace App\Providers;

use App\Models\DTask;
use App\Observers\DTaskObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(\App\Repositories\Interfaces\PTaskStateRepositoryInterface::class, \App\Repositories\PTaskStateRepository::class);
        $this->app->bind(\App\Services\PTaskStateServices\PTaskStateService::class, function ($app) {
            return new \App\Services\PTaskStateServices\PTaskStateService($app->make(\App\Repositories\Interfaces\PTaskStateRepositoryInterface::class));
        });

        $this->app->bind(\App\Repositories\Interfaces\DTaskRepositoryInterface::class, \App\Repositories\DTaskRepository::class);
        $this->app->bind(\App\Services\DTaskServices\DTaskService::class, function ($app) {
            return new \App\Services\DTaskServices\DTaskService($app->make(\App\Repositories\Interfaces\DTaskRepositoryInterface::class));
        });

        
        $this->app->bind(\App\Repositories\Interfaces\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
        $this->app->bind(\App\Services\UserServices\UserService::class, function ($app) {
            return new \App\Services\UserServices\UserService($app->make(\App\Repositories\Interfaces\UserRepositoryInterface::class));
        });


        DTask::observe(DTaskObserver::class);

    }
}

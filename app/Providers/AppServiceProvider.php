<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // DayRepository
        $this->app->bind(
            \App\Repositories\DayRepositoryInterface::class,
            \App\Repositories\DayRepository::class
        );
        // WorkRepository
        $this->app->bind(
            \App\Repositories\WorkRepositoryInterface::class,
            \App\Repositories\WorkRepository::class
        );
        // RestRepository
        $this->app->bind(
            \App\Repositories\RestRepositoryInterface::class,
            \App\Repositories\RestRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

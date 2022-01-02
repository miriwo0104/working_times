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
        $this->app->bind(
            \App\Repositories\DayRepositoryInterface::class,
            \App\Repositories\DayRepository::class
        );
        $this->app->bind(
            \App\Repositories\WorkRepositoryInterface::class,
            \App\Repositories\WorkRepository::class
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

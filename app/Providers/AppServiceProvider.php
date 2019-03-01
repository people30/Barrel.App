<?php

namespace App\Providers;

use App\Repositories;
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
        //
        $this->app->singleton(Repositories\ITasteRepository::class, Repositories\TasteRepository::class);
        $this->app->singleton(Repositories\IDesignationRepository::class, Repositories\DesignationRepository::class);
        $this->app->singleton(Repositories\IAreaRepository::class, Repositories\AreaRepository::class);
        $this->app->singleton(Repositories\ISizeRepository::class, Repositories\SizeRepository::class);
        $this->app->singleton(Repositories\IBrewerRepository::class, Repositories\BrewerRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // MySql 5.7.7 以前のアレ
        \Schema::defaultStringLength(191);
    }
}

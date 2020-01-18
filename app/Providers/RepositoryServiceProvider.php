<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {

        $this->app->bind(
            "App\Repositories\Contracts\BalanceInterface",
            "App\Repositories\BalanceRepository"
        );

        $this->app->bind(
            "App\Repositories\Contracts\UserInterface",
            "App\Repositories\UserRepository"
        );

        $this->app->bind(
            "App\Repositories\Contracts\TransactionInterface",
            "App\Repositories\TransactionRepository"
        );
    }

    public function boot()
    {
        //
    }
}

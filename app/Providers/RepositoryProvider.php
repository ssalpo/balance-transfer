<?php

namespace App\Providers;

use App\Balance;
use App\Repositories\BalanceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('App\Repositories\Contracts\BalanceInterface', function ($app) {
            return new BalanceRepository(new Balance());
        });
    }


    public function boot()
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Models\Bracelet;
use App\Observers\BraceletObserver;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Bracelet::observe(BraceletObserver::class);
    }
}

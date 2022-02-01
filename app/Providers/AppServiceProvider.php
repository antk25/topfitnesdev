<?php

namespace App\Providers;

use App\Models\Bracelet;
use App\Observers\BraceletObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
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

        Relation::enforceMorphMap([
            'post' => 'App\Models\Post',
            'bracelet' => 'App\Models\Bracelet',
            'comparison' => 'App\Models\Comparison',
            'manual' => 'App\Models\Manual',
            'overview' => 'App\Models\Overview',
            'rating' => 'App\Models\Rating',
            'user' => 'App\Models\User',
            'menuitem' => 'App\Models\MenuItem',
            'staticPage' => 'App\Models\StaticPage',
        ]);
    }
}

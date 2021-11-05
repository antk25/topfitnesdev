<?php

namespace App\Providers;

use App\Http\ViewComposers\NavHeaderComposer;
use App\Http\ViewComposers\NavGroupHeaderComposer;
use App\Http\ViewComposers\NotifyAdminComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // FIX Старый вариант без разделения на классы

        // View::composer('layouts.parts.menu', function($view) {
        //     $view->with(['items' => MenuRating::all()]);
        // });

        View::composer('layouts.parts.header', NavHeaderComposer::class);
        View::composer('layouts.parts.header-group', NavGroupHeaderComposer::class);
        View::composer('admin.layouts.base', NotifyAdminComposer::class);
    }
}

<?php

namespace App\Providers;

use App\Http\ViewComposers\LinkTreeMapComposer;
use App\Http\ViewComposers\NavHeaderComposer;
use App\Http\ViewComposers\NavGroupHeaderComposer;
use App\Http\ViewComposers\NotifyAdminComposer;
use App\Http\ViewComposers\HtmlComponentsComposer;
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
        View::composer('admin.layouts.parts.link-tree', LinkTreeMapComposer::class);
        View::composer('admin.layouts.parts.htmlcomponents', HtmlComponentsComposer::class);
        View::composer('layouts.parts.header-group', NavGroupHeaderComposer::class);
        View::composer('admin.layouts.base', NotifyAdminComposer::class);
    }
}

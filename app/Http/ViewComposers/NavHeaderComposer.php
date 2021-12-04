<?php

namespace App\Http\ViewComposers;

use App\Models\MenuItem;
use Illuminate\View\View;

class NavHeaderComposer {

    public function compose(View $view) {

        $menuitems = MenuItem::get();

        return $view->with('items', $menuitems);

        // return $view->with('items', MenuItem::header());
    }
}
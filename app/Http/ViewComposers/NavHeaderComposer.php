<?php

namespace App\Http\ViewComposers;

use App\Models\GroupMenu;
use Illuminate\View\View;

class NavHeaderComposer {

    public function compose(View $view) {

        $groupmenu = GroupMenu::with('menuitems')->where('place', 'header')->get();

        return $view->with('items', $groupmenu);

        // return $view->with('items', MenuItem::header());
    }
}
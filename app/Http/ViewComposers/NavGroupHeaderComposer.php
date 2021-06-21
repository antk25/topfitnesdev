<?php

namespace App\Http\ViewComposers;

use App\Models\GroupMenu;
use Illuminate\View\View;

class NavGroupHeaderComposer {
    public function compose(View $view) {
        $groupmenus = GroupMenu::with('menuitems')->get();
        return $view->with('items', $groupmenus);
        // return $view->with('items', MenuItem::header());
    }
}
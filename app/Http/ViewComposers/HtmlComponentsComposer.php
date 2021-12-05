<?php

namespace App\Http\ViewComposers;

use App\Models\HtmlComponent;
use Illuminate\View\View;

class HtmlComponentsComposer {

    public function compose(View $view) {

        $htmlcomponents = HtmlComponent::get();

        return $view->with('items', $htmlcomponents);

        // return $view->with('items', MenuItem::header());
    }
}
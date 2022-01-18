<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class SeoBlock extends Component
{
    public $model;
    public $users;

    /**
     * Create a new component instance.
     *
     * @param $model
     * @param $users
     */
    public function __construct($model, $users)
    {
       $this->model = $model;
       $this->users = $users;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.seo-block');
    }
}

<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class CodemirrorEditor extends Component
{
    public $content;
    public $name;
    public $id;

    /**
     * Create a new component instance.
     *
     * @param $content
     * @param $name
     * @param $id
     */
    public function __construct($content, $name, $id)
    {
        $this->content = $content;
        $this->name = $name;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.codemirror-editor');
    }
}

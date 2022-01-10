<?php

namespace App\View\Components\TableRow;

use Illuminate\View\Component;

class Head extends Component
{
    public $bracelets;
    public $specs;

//    protected $allowedspecsvalue = [
//     'disp_color', 'real_time'
//    ];

    /**
     * create a new component instance.
     *
     * @param $bracelets
     * @param $specs
     */
    public function __construct($bracelets, $specs)
    {
        $this->bracelets = $bracelets;
        $this->specs = $specs;
//        parse_str($specs, $this->specs);
//        $this->specs = explode(",", $specs);

//        if(!in_array($specs, $this->allowedspecsvalue))
//        {
//            $this->specs = 'hello world';
//        }
//        else {
//            $this->specs = $specs;
//        }
    }

    /**
     * get the view / contents that represent the component.
     *
     * @return \illuminate\contracts\view\view|\closure|string
     */
    public function render()
    {
        return view('components.table-row.head');
    }
}

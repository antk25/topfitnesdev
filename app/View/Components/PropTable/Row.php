<?php

namespace App\View\Components\PropTable;

use Illuminate\View\Component;

class Row extends Component
{
    public $type;
    public $unit;
    public $spec;
    protected $allowedTypes = [
        'string', 'array', 'bool', 'color'
    ];
    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param string $unit
     * @param void $spec
     */
    public function __construct($type, $unit, $spec)
    {
       if ($unit != '') {
        $this->unit = $unit;
       }

       if (is_array($spec)) {
           if (count($spec)) {
                $this->spec = $spec;
           }
       }
       else {
           $this->spec = $spec;
       }

       if (!in_array($type, $this->allowedTypes)) {
            $this->type = 'string';
       }
       else {
           $this->type = $type;
       }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.prop-table.row');
    }
}

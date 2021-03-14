<?php

namespace App\Models;

class BraceletsFilter extends QueryFilter {
    // Перенос в абстрактный класс QueryFilter 
    // protected $builder;

    // protected $request;

    // public function __construct($builder, $request) {
   
    //     $this->builder = $builder;

    //     $this->request = $request;
   
    // }

    // public function apply() {

    //     foreach ($this->filters() as $filter => $value) {

    //         if (method_exists($this, $filter)) {

    //             $this->$filter($value);

    //         }

    //     }
    //     return $this->builder;
    
    // }

    public function name($value) {

        $this->builder->where('name', 'like', "%$value%");

    }

    public function oxy_permanent($value) {

        $this->builder->where('oxy_permanent', $value);

    }
    
    public function pulse_permanent($value) {

        $this->builder->where('pulse_permanent', $value);

    }
    
    public function ad_permanent($value) {

        $this->builder->where('ad_permanent', $value);

    }

    public function disp_tech($value) {

        if (! $value) return;
        
        // if ($value == '*')
            
        //     $this->builder;
            
        // else 
        
            $this->builder->where('disp_tech', $value);
       
    }
    // Перенос в абстрактный класс QueryFilter
    // public function filters() {

    //     return $this->request->all();

    // }
}
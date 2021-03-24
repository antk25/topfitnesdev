<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilterContract;

class ProductCheckedTestFilter implements QueryFilterContract
{
    protected $heart_rate;
    protected $disp_tech;

    public function __construct($heart_rate, $disp_tech)
    {
        $this->heart_rate = $heart_rate;
        $this->disp_tech = $disp_tech;
    }

    public function apply($query)
    {
        // dd($this->terms_of_use);
        $query
        ->when($this->heart_rate, function ($query) {
            $query->where('heart_rate', $this->heart_rate);
        })
        ->when($this->disp_tech, function ($query) {
            $query->where('disp_tech', $this->disp_tech);
        });
    }

    // public function shouldRun()
    // {
        // return (bool) $this->value;
    // }
}

<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilterContract;

class ProductCheckedFilterAdmin implements QueryFilterContract
{
    protected $published;
    protected $selection;

    public function __construct($published, $selection)
    {
        $this->published = $published;
        $this->selection = $selection;
    }

    public function apply($query)
    {
        // dd($this->terms_of_use);
        $query
        ->when($this->published, function ($query) {
            $query->where('published', $this->published);
        })
        ->when($this->selection, function ($query) {
            $query->where('selection', $this->selection);
        });
    }

    // public function shouldRun()
    // {
        // return (bool) $this->value;
    // }
}

<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilterContract;

class ProductBrandFilter implements QueryFilterContract
{
    protected $brand;

    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    public function apply($query)
    {
        // dd($this->terms_of_use);
        $query
        ->when($this->brand, function ($query) {
            $query->where('brand_id', $this->brand);
        });
    }

    // public function shouldRun()
    // {
        // return (bool) $this->value;
    // }
}

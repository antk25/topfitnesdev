<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilterContract;

class BraceletPriceRangeSelect implements QueryFilterContract
{
    // protected $minPrice;
    protected $maxPrice;

    public function __construct($minPrice, $maxPrice)
    {
         $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function apply($query)
    {
        if (!$this->maxPrice) {
            return;
        }
        $query
             ->when($this->minPrice, function ($query) {
                 $query->where('avg_price', '>=', $this->minPrice);
             })
            ->when($this->maxPrice, function ($query) {
                $query->where('avg_price', '<=', $this->maxPrice);
            });
    }
}

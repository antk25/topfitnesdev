<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletPriceRangeFilter extends AbstractEloquentFilter
{
    protected $minPrice;
    protected $maxPrice;

    public function __construct($maxPrice, $minPrice)
    {
        $this->maxPrice = $maxPrice;
        $this->minPrice = $minPrice;
    }

    public function isApplicable(): bool
    {
        return is_numeric($this->maxPrice);
    }

    public function apply(Builder $query): Builder
    {
        return $query
        ->when($this->minPrice, function ($query) {
            $query->where('avg_price', '>=', $this->minPrice);
        })
        ->when($this->maxPrice, function ($query) {
            $query->where('avg_price', '<=', $this->maxPrice);
        });
    }

}

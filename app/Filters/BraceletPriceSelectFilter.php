<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletPriceSelectFilter extends AbstractEloquentFilter
{
    protected $minPrice;
    protected $maxPrice;

    public function __construct($minPrice, $maxPrice)
    {
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function isApplicable(): bool
    {
        return is_numeric($this->minPrice) & is_numeric($this->maxPrice);
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereBetween('avg_price', [$this->minPrice, $this->maxPrice]);
    }

}

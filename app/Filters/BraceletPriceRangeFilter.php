<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletPriceRangeFilter extends AbstractEloquentFilter
{
    // protected $minPrice;
    protected $max_price;

    public function __construct($max_price)
    {
        $this->max_price = $max_price;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder
        ->when($this->max_price, function ($query) {
            $query->where('avg_price', '<=', $this->max_price);
        });
    }

}

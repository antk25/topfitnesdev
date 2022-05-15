<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletBrandFilter extends AbstractEloquentFilter
{
    protected $brand;

    public function __construct($brand)
    {
        $this->brand = $brand;
    }

    public function apply(Builder $query): Builder
    {
        return $query
        ->when($this->brand, function ($query) {
            $query->where('brand_id', $this->brand);
        });
    }
}

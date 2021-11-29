<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class NameFilter extends AbstractEloquentFilter
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder->where('name', 'like', "{$this->name}%");
    }
}

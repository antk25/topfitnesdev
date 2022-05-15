<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletJsonDestinationFilter extends AbstractEloquentFilter
{
    protected $destination;

    public function __construct($destination)
    {
        $this->destination = $destination;
    }

    public function apply(Builder $query): Builder
    {
        return $query
                ->when($this->destination == 'бег', function ($builder) {
                    $builder->whereJsonContains('destination', ['бег']);
                });
    }
}

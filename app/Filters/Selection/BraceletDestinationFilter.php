<?php

namespace App\Filters\Selection;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletDestinationFilter extends AbstractEloquentFilter
{
    protected $selectedDestination;

    public function __construct($selectedDestination)
    {
        $this->selectedDestination = $selectedDestination;
    }

    public function apply(Builder $query): Builder
    {
        return $query
        ->when($this->selectedDestination, function ($query) {
            $query->whereJsonContains('destination', $this->selectedDestination);
        });
    }
}

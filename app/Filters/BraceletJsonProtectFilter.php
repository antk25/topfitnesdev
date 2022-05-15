<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletJsonProtectFilter extends AbstractEloquentFilter
{
    protected $protect_stand;

    public function __construct($protect_stand)
    {
        $this->protect_stand = $protect_stand;
    }

    public function apply(Builder $query): Builder
    {
       return $query
             ->when($this->protect_stand == 'high', function ($query) {
                 $query->whereJsonContains('protect_stand', ['WR50', 'IP68']);
             })
             ->when($this->protect_stand == 'medium', function ($query) {
                 $query->where(function($query)
                 {
                     $query->whereJsonContains('protect_stand', 'IP65')
                     ->orWherejsonContains('protect_stand', 'IP67');
                 });
             });
    }
}

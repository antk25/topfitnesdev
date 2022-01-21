<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletJsonFieldsFilter extends AbstractEloquentFilter
{
    protected $protect_stand;
    protected $compatibility;
    protected $destination;

    public function __construct($protect_stand, $compatibility, $destination)
    {
        $this->protect_stand = $protect_stand;
        $this->compatibility = $compatibility;
        $this->destination = $destination;
    }

    public function apply(Builder $builder): Builder
    {
       return $builder
            ->when($this->protect_stand == 'high', function ($builder) {
                $builder->whereJsonContains('protect_stand', ['WR50', 'IP68']);
            })
            ->when($this->protect_stand == 'medium', function ($builder) {
                $builder->WhereJsonContains('protect_stand', 'IP65')->orWherejsonContains('protect_stand', 'IP67');
            })
            ->when($this->compatibility == 'Android', function ($builder) {
                $builder->whereJsonContains('compatibility', ['Android']);
            })
            ->when($this->compatibility == 'iOS', function ($builder) {
                $builder->whereJsonContains('compatibility', ['iOS']);
            })
           ->when($this->destination == 'бег', function ($builder) {
               $builder->whereJsonContains('destination', ['бег']);
           });
    }
}

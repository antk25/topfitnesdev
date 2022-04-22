<?php

namespace App\Filters\Selection;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletCompatibilityFilter extends AbstractEloquentFilter
{
    protected $compatibility;

    public function __constructor($compatibility)
    {
        $this->compatibility = $compatibility;
    }

    public function apply(Builder $query): Builder
    {
        return $query

        ->when($this->compatibility == 'Android', function ($builder) {
            $builder->whereJsonContains('compatibility', ['Android 4.3'])
            ->orWherejsonContains('compatibility', 'Android 4.4')
            ->orWherejsonContains('compatibility', 'Android 5.0')
            ->orWherejsonContains('compatibility', 'Android 6.0');
        })
        ->when($this->compatibility == 'iOS', function ($builder) {
            $builder->whereJsonContains('compatibility', ['iOS 7.0'])
            ->orWherejsonContains('compatibility', 'iOS 8.0')
            ->orWherejsonContains('compatibility', 'iOS 8.4')
            ->orWherejsonContains('compatibility', 'iOS 9.0')
            ->orWherejsonContains('compatibility', 'iOS 10.0');
        });
    }
}

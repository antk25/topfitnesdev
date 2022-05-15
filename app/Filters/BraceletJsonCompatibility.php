<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletJsonCompatibility extends AbstractEloquentFilter
{
    protected $compatibility;

    public function __construct($compatibility)
    {
        $this->compatibility = $compatibility;
    }

    public function apply(Builder $query): Builder
    {
        return $query
            ->when($this->compatibility == 'Android', function ($query) {
                $query->where(function($query)
                {
                    $query->whereJsonContains('compatibility', 'Android')
                        ->orWhereJsonContains('compatibility', 'Android 4.3')
                        ->orWherejsonContains('compatibility', 'Android 4.4')
                        ->orWherejsonContains('compatibility', 'Android 5.0')
                        ->orWherejsonContains('compatibility', 'Android 6.0');
                });
            })
            ->when($this->compatibility == 'iOS', function ($query) {
                $query->where(function($query)
                {
                    $query->whereJsonContains('compatibility', 'iOS')
                        ->orWherejsonContains('compatibility', 'iOS 7.0')
                        ->orWherejsonContains('compatibility', 'iOS 8.0')
                        ->orWherejsonContains('compatibility', 'iOS 8.4')
                        ->orWherejsonContains('compatibility', 'iOS 9.0')
                        ->orWherejsonContains('compatibility', 'iOS 10.0');
                });

            });
    }
}

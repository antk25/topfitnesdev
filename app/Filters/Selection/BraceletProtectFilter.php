<?php

namespace App\Filters\Selection;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletProtectFilter extends AbstractEloquentFilter
{
    protected $protect;

    public function __construct($protect)
    {
        $this->protect = $protect;
    }

    public function apply(Builder $query): Builder
    {
        return $query
        ->when($this->protect == 'high', function ($builder) {
                $builder->whereJsonContains('protect_stand', ['WR50', 'IP68']);
            })
            ->when($this->protect == 'medium', function ($builder) {
                $builder->whereJsonContains('protect_stand', 'IP65')
                ->orWherejsonContains('protect_stand', 'IP67');
            });
    }
}

<?php

namespace App\Filters\Selection;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletDispColorFilter extends AbstractEloquentFilter
{
    protected $dispColor;

    public function __construct($dispColor)
    {
        $this->dispColor = $dispColor;
    }

    // public function isApplicable(): bool
    // {
    //     return $this->dispColor && is_bool($this->dispColor);
    // }

    public function apply(Builder $query): Builder
    {
        return $query->where('disp_color', $this->dispColor);
    }
}

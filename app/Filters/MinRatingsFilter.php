<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class MinRatingsFilter extends AbstractEloquentFilter
{
    protected $min_rating;

    public function __construct($min_rating)
    {
        $this->min_rating = $min_rating;
    }

    public function apply(Builder $builder): Builder
    {
        return $builder
        ->when($this->min_rating, function ($query) {
            $query->where('average_grade', '>=', $this->min_rating);
        });

    }

}

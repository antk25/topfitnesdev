<?php

namespace App\ResourceFiltering\ProductFilters;

use App\Models\Rating;
use App\ResourceFiltering\QueryFilterContract;

class ProductMinRatingsFilter implements QueryFilterContract
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function apply($query)
    {
        if (! $this->value) {
            return;
        }
        $query->where('grade_bracelet', '>=', $this->value);
    }
}

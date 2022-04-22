<?php

namespace App\Filters\Selection;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletDispSizeFilter extends AbstractEloquentFilter
{
    protected $minDispSize;
    protected $maxDispSize;

    public function __construct($minDispSize, $maxDispSize)
    {
        $this->minDispSize = $minDispSize;
        $this->maxDispSize = $maxDispSize;
    }

    public function isApplicable(): bool
    {
        return is_numeric($this->minDispSize) & is_numeric($this->maxDispSize);
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereBetween('disp_diag', [$this->minDispSize, $this->maxDispSize]);
    }
}

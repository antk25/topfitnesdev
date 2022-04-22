<?php

namespace App\Filters\Selection;

use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BraceletDispDpiFilter extends AbstractEloquentFilter
{
    protected $minDispDpi;
    protected $maxDispDpi;

    public function __construct($minDispDpi, $maxDispDpi)
    {
        $this->minDispDpi = $minDispDpi;
        $this->maxDispDpi = $maxDispDpi;
    }

    public function isApplicable(): bool
    {
        return is_numeric($this->minDispDpi) & is_numeric($this->maxDispDpi);
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereBetween('disp_ppi', [$this->minDispDpi, $this->maxDispDpi]);
    }
}

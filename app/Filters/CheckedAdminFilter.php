<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class CheckedAdminFilter extends AbstractEloquentFilter
{
    public function __construct($published, $selection)
    {
       $this->published = $published;
       $this->selection = $selection;
    }

    public function isApplicable(): bool
    {
        // return $this->published & $this->selection;
        if ($this->published != null | $this->selection != null)
        {
            return true;
        }

        else
        {
            return false;
        }
    }

    // public function apply(Builder $builder): Builder
    // {
    //     $query
    //     ->when($this->published, function ($query) {
    //         $query->where('published', $this->published);
    //     });
    // }

    public function apply(Builder $builder): Builder
    {
        return $builder->when($this->published, function($query)
        {
            $query->where('published', $this->published);
        })
        ->when($this->selection, function ($query) {
            $query->where('selection', $this->selection);
        });
            // ->where('published', $this->published);
    }
}

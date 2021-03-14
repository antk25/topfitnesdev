<?php

namespace App\ResourceFiltering\ProductFilters;

use App\Models\Bracelet;
use App\ResourceFiltering\QueryFilterContract;
use Illuminate\Support\Str;


class ProductJsonFieldsFilter implements QueryFilterContract
{
    protected $terms_of_use;


    public function __construct($terms_of_use)
    {
            $this->terms_of_use = $terms_of_use;
    }

    public function apply($query)
    {
        if (! $this->terms_of_use) {
            return;
        }
        
        if (is_array($this->terms_of_use)) {

        $query->when($this->terms_of_use, function ($query) {
           foreach ($this->terms_of_use as $item) {
            $query->whereJsonContains('terms_of_use', $item);
            }
        });
        }
        else {

            $query->whereJsonContains('terms_of_use', $this->terms_of_use);

        }
    }
}

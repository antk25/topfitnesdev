<?php

namespace App\ResourceFiltering\ProductFilters;

use App\Models\Bracelet;
use App\ResourceFiltering\QueryFilterContract;
use Illuminate\Support\Str;


class ProductJsonFieldsFilter implements QueryFilterContract
{
    protected $protect_stand;


    public function __construct($protect_stand)
    {
            $this->protect_stand = $protect_stand;
    }

    public function apply($query)
    {
        if (! $this->protect_stand) {
            return;
        }
        
        if (is_array($this->protect_stand)) {

        $query->when($this->protect_stand, function ($query) {
           foreach ($this->protect_stand as $item) {
            $query->whereJsonContains('protect_stand', $item);
            }
        });
        }
        else {

            $query->whereJsonContains('protect_stand', $this->protect_stand);

        }
    }
}

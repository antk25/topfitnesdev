<?php

namespace App\ResourceFiltering\ProductFilters;

use App\Models\Bracelet;
use App\ResourceFiltering\QueryFilterContract;
use Illuminate\Support\Str;


class ProductJsonFieldsFilter implements QueryFilterContract
{
    protected $protect_stand;
    protected $compatibility;


    public function __construct($protect_stand, $compatibility)
    {
            $this->protect_stand = $protect_stand;
            $this->compatibility = $compatibility;
    }

    public function apply($query)
    {
        if (! $this->protect_stand && ! $this->compatibility) {
            return;
        }


        $query
        ->when($this->protect_stand == 'high', function ($query) {
            $query->whereJsonContains('protect_stand', ['WR50', 'IP68']);
        })
        ->when($this->protect_stand == 'medium', function ($query) {
            $query->WhereJsonContains('protect_stand', 'IP65')->orWherejsonContains('protect_stand', 'IP67');
        })
        ->when($this->compatibility == 'Android', function ($query) {
            $query->whereJsonContains('compatibility', ['Android']);
        })
        ->when($this->compatibility == 'iOS', function ($query) {
        $query->whereJsonContains('compatibility', ['iOS']);
    });



    }
}

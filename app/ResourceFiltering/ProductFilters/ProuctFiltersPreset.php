<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProductSearchFilter;
use App\ResourceFiltering\ProductFilters\ProductMinRatingsFilter;
use App\ResourceFiltering\ProductFilters\ProductPriceRangeFilter;
use App\ResourceFiltering\ProductFilters\ProductCheckedFilter;
use App\ResourceFiltering\ProductFilters\ProductJsonFieldsFilter;

class ProuctFiltersPreset
{
    public function getForMarketingMenu($search, $disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $disp_sens, $nfc, $min_rating, $protect_stand, $min_price, $max_price, $brand)
    {
        return new QueryFilters([
            new ProductSearchFilter($search),
            new ProductBrandFilter($brand),
            new ProductCheckedFilter($disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $disp_sens, $nfc),
            new ProductMinRatingsFilter($min_rating),
            new ProductJsonFieldsFilter($protect_stand),
            new ProductPriceRangeFilter($min_price, $max_price),
        ]);
    }

    // public function getForMarketingMenu($request)
    // {
        // return new QueryFilters([
            // new ProductSearchFilter($request->search),
            // new ProductCheckedFilter($request->disp_tech, $request->heart_rate, $request->blood_oxy, $request->blood_pressure, $request->smart_alarm, $request->gps, $request->disp_sens, $request->nfc),
            // new ProductMinRatingsFilter($request->min_rating),
            // new ProductJsonFieldsFilter($request->terms_of_use),
            // new ProductPriceRangeFilter($request->min_price, $request->max_price),
        // ]);
    // }

    public function getForAdmin($request)
    {
        return new QueryFilters([
            new ProductSearchFilter($request->search),
            new ProductMinRatingsFilter($request->min_rating),
            new ProductPriceRangeFilter($request->min_price, $request->max_price),
        ]);
    }
}

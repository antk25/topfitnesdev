<?php

namespace App\ResourceFiltering\ProductFilters;

use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProductSearchFilter;
use App\ResourceFiltering\ProductFilters\ProductMinRatingsFilter;
use App\ResourceFiltering\ProductFilters\ProductPriceRangeFilter;
use App\ResourceFiltering\ProductFilters\ProductCheckedFilter;
use App\ResourceFiltering\ProductFilters\ProductJsonFieldsFilter;
use App\ResourceFiltering\ProductFilters\BraceletPriceRangeSelect;

class ProductFiltersPreset
{
    public function getForMarketingMenu($disp_tech, $heart_rate, $blood_oxy, $blood_pressure, $smart_alarm, $gps, $nfc, $min_rating, $protect_stand, $max_price, $brand, $country, $compatibility): QueryFilters
    {
        return new QueryFilters([
            // new ProductSearchFilter($search),
            new ProductBrandFilter($brand),
            new ProductCheckedFilter($disp_tech, $heart_rate, $blood_pressure, $smart_alarm, $gps, $blood_oxy, $nfc, $country),
            new ProductMinRatingsFilter($min_rating),
            new ProductJsonFieldsFilter($protect_stand, $compatibility),
            new ProductPriceRangeFilter($max_price),
        ]);
    }

     public function getForSelection($protect_stand, $compatibility, $minPrice, $maxPrice): QueryFilters
     {
         return new QueryFilters([
//             new ProductCheckedFilter($minPrice, $maxPrice),
             new ProductJsonFieldsFilter($protect_stand, $compatibility),
             new BraceletPriceRangeSelect($minPrice, $maxPrice),
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

//    public function getForAdmin($request): QueryFilters
//    {
//        return new QueryFilters([
//            new ProductSearchFilter($request->search),
//            new ProductMinRatingsFilter($request->min_rating),
//            new ProductPriceRangeFilter($request->min_price, $request->max_price),
//        ]);
//    }
}

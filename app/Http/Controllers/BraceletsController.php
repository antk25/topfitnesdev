<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProductSearchFilter;
use App\ResourceFiltering\ProductFilters\ProuctFiltersPreset;
use App\ResourceFiltering\ProductFilters\ProductMinRatingsFilter;
use App\ResourceFiltering\ProductFilters\ProductPriceRangeFilter;

class BraceletsController extends Controller
{
    public function index(Request $request, ProuctFiltersPreset $preset) {
        
        
        $bracelets = Bracelet::filter($preset->getForMarketingMenu($request))->paginate(20);

        return view('bracelets.index', compact('bracelets'));
    }
    
    public function show($slug) {
        
        $bracelet = Bracelet::where('slug', $slug)->first();       
        $media = $bracelet->getMedia('bracelet');
        return view('bracelets.show', compact('bracelet', 'media'));
    }
    
}

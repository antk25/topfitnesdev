<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Brand;
use App\ResourceFiltering\QueryFilters;
use App\ResourceFiltering\ProductFilters\ProductSearchFilter;
use App\ResourceFiltering\ProductFilters\ProuctFiltersPreset;
use App\ResourceFiltering\ProductFilters\ProductMinRatingsFilter;
use App\ResourceFiltering\ProductFilters\ProductPriceRangeFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BraceletsController extends Controller
{
    // public function index(Request $request, ProuctFiltersPreset $preset) {

        // $bracelets = Bracelet::with('sellers', 'media')->filter($preset->getForMarketingMenu($request))->paginate(20);

        // return view('bracelets.index', compact('bracelets'));
    // }

    public function index(Request $request)
    {

        // $bracelets = Bracelet::with('sellers', 'media')->get();

        $bracelets = QueryBuilder::for(Bracelet::class)
                ->with('sellers', 'media')
                ->allowedFilters(['name',
                AllowedFilter::scope('protect_stand'),
                AllowedFilter::exact('smart_alarm'),
                AllowedFilter::exact('blood_pressure'),
                AllowedFilter::exact('heart_rate'),
                AllowedFilter::exact('blood_oxy'),
                AllowedFilter::exact('gps'),
                ])
                ->get();

        $brands = Brand::pluck('id', 'name');

        return view('bracelets.index', compact('bracelets', 'brands', 'request'));

    }

    public function show($slug) {

        $bracelet = Bracelet::where('slug', $slug)->first();
        $media = $bracelet->getMedia('bracelet');
        return view('bracelets.show', compact('bracelet', 'media'));
    }

    public function selection() {

        return view('bracelets.selection');
    }

}
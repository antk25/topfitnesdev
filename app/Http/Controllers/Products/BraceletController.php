<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Brand;

class BraceletController extends Controller
{
    // public function index(Request $request, ProductFiltersPreset $preset) {

    //     $bracelets = Bracelet::with('sellers', 'media')->filter($preset->getForMarketingMenu($request))->paginate(20);

    //     return view('bracelets.index', compact('bracelets'));
    // }

    public function index()
    {

        return view('bracelets.index');

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Bracelet;
use Auth;

class RatingsController extends Controller
{
    public function show($slug) {

        $rating = Rating::where('slug', $slug)->first();
        $topbracelets = Bracelet::where('hit', 1)->limit(3)->get();
        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else 
        {
            $user = null;
        }
        // $media = $rating->getMedia('rating');
        return view('ratings.show', compact('rating', 'user', 'topbracelets'));
    }
}

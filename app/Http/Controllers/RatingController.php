<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Bracelet;
use Auth;

class RatingController extends Controller
{
    public function show($slug) {

        $rating = Rating::where('slug', $slug)->with('bracelets')->first();

        $bracelets = $rating->bracelets;

        $topbracelets = Bracelet::where('hit', 1)->limit(3)->get();
        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else
        {
            $user = null;
        }
        // $media = $rating->getMedia('rating');
        return view('ratings.show', compact('rating', 'user', 'topbracelets', 'bracelets'));
    }
}

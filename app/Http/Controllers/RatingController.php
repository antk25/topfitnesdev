<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Bracelet;
use Auth;

class RatingController extends Controller
{
    public function index() {

       $ratings = Rating::where('published', 1)->paginate(10);

       return view('ratings.index', compact('ratings'));

    }

    public function show(Rating $rating) {

        $topbracelets = Bracelet::where('hit', 1)->limit(3)->get();

        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else
        {
            $user = null;
        }

        return view('ratings.show', compact('rating', 'user', 'topbracelets'));
    }
}

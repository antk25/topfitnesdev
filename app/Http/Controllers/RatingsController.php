<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingsController extends Controller
{
    public function show($slug) {

        $rating = Rating::where('slug', $slug)->first();
        $user = \Auth::user()->id;
        // $media = $rating->getMedia('rating');
        return view('ratings.show', compact('rating', 'user'));
    }
}

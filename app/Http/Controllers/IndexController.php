<?php

namespace App\Http\Controllers;

use App\Models\Bracelet;
use App\Models\Rating;
use App\Models\Review;

class IndexController extends Controller
{
    public function index()
    {
        $hits = Bracelet::with('media', 'sellers', 'grades')->where('hit', 1)->get();

        $reviews = Review::with('reviewable')->orderBy('id', 'desc')->limit(3)->get();

        $lastratings = Rating::orderByDesc('updated_at')->limit(3)->get();

        return view('index', compact('hits', 'reviews', 'lastratings'));
    }
}

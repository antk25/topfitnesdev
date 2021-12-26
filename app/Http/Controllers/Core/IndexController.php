<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Review;

class IndexController extends Controller
{
    public function index()
    {
        $hits = Bracelet::with('media', 'sellers', 'grades')->where('hit', 1)->get();

        $reviews = Review::with('reviewable')->orderBy('id', 'desc')->limit(3)->get();

        return view('index', compact('hits', 'reviews'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bracelet;
use App\Models\Review;

class IndexController extends Controller
{
    public function index() 
    {
        $hits = Bracelet::with('media', 'sellers', 'grades')->where('hit', 1)->get();
        
        $reviews = Review::with('bracelet')->orderBy('id', 'desc')->limit(3)->get();
        
        return view('index', compact('hits', 'reviews'));
    }
}

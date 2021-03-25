<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bracelet;

class IndexController extends Controller
{
    public function index() 
    {
        $hits = Bracelet::with('media', 'sellers', 'grades')->where('hit', 1)->get();

        return view('index', compact('hits'));
    }
}

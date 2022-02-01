<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function show(StaticPage $staticPage)
    {
        return view('static-pages.show', compact('staticPage'));
    }
}

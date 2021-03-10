<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bracelet;

class BraceletsController extends Controller
{
    public function index() {

        $bracelets = Bracelet::paginate(15);

        return view('bracelets.index', compact('bracelets'));
    }
    
}

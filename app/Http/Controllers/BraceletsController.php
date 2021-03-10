<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bracelet;
use Spatie\QueryBuilder\QueryBuilder;

class BraceletsController extends Controller
{
    public function index() {

        $bracelets = QueryBuilder::for(Bracelet::class)
                ->allowedFilters([
                    'name',
                    'replaceable_strap',
                    ])
                ->paginate(15);

        return view('bracelets.index', compact('bracelets'));
    }
    
}

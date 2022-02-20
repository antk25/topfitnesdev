<?php

namespace App\Http\Controllers;

use App\Models\Comparison;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComparisonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
       $comparisons = Comparison::paginate(10);

       return view('comparisons.index', compact('comparisons'));
    }

    /**
     * Display the specified resource.
     *
     * @param Comparison $comparison
     * @return Application|Factory|View
     */
    public function show(Comparison $comparison)
    {
        $bracelets = $comparison->bracelets;

        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else
        {
            $user = null;
        }

        $comparison->loadCount('comments');

        return view('comparisons.show', compact('comparison', 'user', 'bracelets'));
    }

}

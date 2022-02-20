<?php

namespace App\Http\Controllers;

use App\Models\Overview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $overviews = Overview::paginate(10);

        return view('overviews.index', compact('overviews'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\overview  $overview
     * @return Application|Factory|View
     */
    public function show(overview $overview)
    {
        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else
        {
            $user = null;
        }
        $overview->loadCount('comments');

        return view('overviews.show', compact('overview', 'user'));
    }

}

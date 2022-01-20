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
     * @return void
     */
    public function index()
    {
        //
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
        // $media = $rating->getMedia('rating');
        return view('overviews.show', compact('overview', 'user'));
    }

}

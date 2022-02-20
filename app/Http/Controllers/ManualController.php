<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Manual;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $manuals = Manual::paginate(10);

        return view('manuals.index', compact('manuals'));
    }

    /**
     * Display the specified resource.
     *
     * @param Manual $manual
     * @return Application|Factory|View
     */
    public function show(Manual $manual)
    {
        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else
        {
            $user = null;
        }

       $manual->loadCount('comments');
    //    $manual->load('commentsParentless');

    //    $comments = $manual->comments->where('parent_id', null);


        return view('manuals.show', compact('manual', 'user'));
    }
}

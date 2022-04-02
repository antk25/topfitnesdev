<?php

namespace App\Http\Controllers;

use App\Models\Bracelet;
use App\Models\Comment;
use App\Models\Overview;
use App\Models\Rating;
use App\Models\Review;

class IndexController extends Controller
{
    public function index()
    {
        $hits = Bracelet::with('media', 'sellers', 'grades')->where('hit', 1)->get();

        $reviews = Review::with('reviewable')->orderBy('id', 'desc')->limit(3)->get();

        $comments = Comment::with('commentable')->orderBy('created_at', 'desc')->limit(4)->get();

        $lastratings = Rating::orderByDesc('updated_at')->limit(3)->get();

        $lastoverviews = Overview::orderByDesc('updated_at')->limit(3)->get();

        return view('index', compact('hits', 'reviews', 'lastratings', 'comments', 'lastoverviews'));
    }
}

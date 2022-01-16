<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Auth;

class PostController extends Controller

{
    public function index() {
        $posts = Post::paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function show($slug) {

        $post = Post::where('slug', $slug)->first();
        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else
        {
            $user = null;
        }
        // $media = $rating->getMedia('rating');
        return view('posts.show', compact('post', 'user'));
    }
}

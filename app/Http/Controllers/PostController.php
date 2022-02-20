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

    public function show(Post $post) {

        if (Auth::check()) {
            $user = \Auth::user()->id;
        }
        else
        {
            $user = null;
        }
        $post->loadCount('comments');

        return view('posts.show', compact('post', 'user'));
    }
}

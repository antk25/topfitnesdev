<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Auth;

class PostController extends Controller

{
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

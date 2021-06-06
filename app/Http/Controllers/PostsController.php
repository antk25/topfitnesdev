<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Auth;

class PostsController extends Controller

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Rating;

class CommentController extends Controller
{
    // public function store(Request $request)
    // {
        // $comment = new Comment;
        // $comment->comment = $request->comment;
        // $comment->user()->associate($request->user());
        // $post = Post::find($request->post_id);
        // $post->comments()->save($comment);
        // return back();
    // }

    public function replyStore(Request $request)
    {
       $reply = new Comment([
            'comment' => request('comment'),
            'parent_id' => request('parent_id'),
            'user_id' => request('user_id'),
            'commentable_type' => request('commentable_type'),
            'commentable_id' => request('commentable_id')
            ]);

       $reply->save();

       return back();

    }
}


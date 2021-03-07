<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Rating;
use App\Models\Comment;

use Spatie\QueryBuilder\QueryBuilder;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = QueryBuilder::for(Comment::class)
        ->allowedIncludes(['commentable'])
        ->allowedFilters(['commentable.name','ratings.name'])
        ->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::pluck('name', 'id')->all();

        $users = User::pluck('email', 'id')->all();

        $ratings = Rating::pluck('name', 'id')->all();

        return view('admin.comments.create', compact('posts', 'users', 'ratings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $model = request('model_name');

       $comment = new Comment([
            'comment' => request('comment'),
            //'user_id' => request('user_id'),
            ]);

       $comment->user()->associate($request->user_id);

       if ($model == 'Post') {
           $essense = Post::find($request->get('post_id'));
       }
       elseif ($model == 'Rating') {
           $essense = Rating::find($request->get('rating_id'));
       }

       $essense->comments()->save($comment);

       return back();
    }

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::find($id);

        $users = User::pluck('email', 'id')->all();

        $commentuser = User::where('id', $comment->user_id)->select('email')->first();

        return view('admin.comments.edit', compact('comment', 'users', 'commentuser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $comment = Comment::find($id);

       $comment->update([
        'comment' => request('comment'),
        'commentable_id' => request('commentable_id'),
        'commentable_type' => request('commentable_type'),
        'user_id' => request('user_id'),
    ]);

       return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

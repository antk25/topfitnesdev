<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Rating;
use App\Models\Comment;

use App\Notifications\NewCommentNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::with('user')->paginate(20);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = Post::get();

        $users = User::pluck('email', 'id')->all();

        $ratings = Rating::get();

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
       $pst = $request->item_id;

       $pst = explode(",", $pst);

       $comment = new Comment([
            'comment' => request('comment'),
            // 'parent_id' => request('parent_id'),
            'user_id' => request('user_id'),
            'commentable_type' => $pst[1],
            'commentable_id' => $pst[0],
            'created_at' => request('created_at'),
            'username' => request('username'),
            'useremail' => request('useremail'),
            ]);

        $comment->save();

    //    $comment->user()->associate($request->user_id);

       return back();
    }

    public function replyStore(Request $request)
    {
       $reply = new Comment([
            'comment' => request('comment'),
            'parent_id' => request('parent_id'),
            'user_id' => request('user_id'),
            'commentable_type' => request('commentable_type'),
            'commentable_id' => request('commentable_id'),
            'created_at' => request('created_at'),
            'username' => request('username'),
            'useremail' => request('useremail'),
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

       $data = $request->all();

    //    if (empty($comment->published_at) && isset($data['is_published'])) {

    //     $data['published_at'] = Carbon::now()->format('d/m/Y');

    //    }

       $result = $comment
            ->fill($data)
            ->update();

       if ($result) {
          return redirect()
                 ->route('comments.edit', $comment->id)
                 ->with(['success' => 'Успешно сохранено']);
       } else {
        return back()
                ->withErrors(['msg' => 'Ошибка сохранения'])
                ->withInput();
       }


    //    $comment->update([
    //     'comment' => request('comment'),
    //     'commentable_id' => request('commentable_id'),
    //     'commentable_type' => request('commentable_type'),
    //     'user_id' => request('user_id'),
    //     'created_at' => request('created_at')
    // ]);

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
        Comment::destroy($id);

        return back();
    }

}

<?php

namespace App\Http\Livewire\Comment;

use Livewire\Component;
use App\Models\Comment;

use App\Models\User;
use Carbon\Carbon;

class Comments extends Component
{
    public $comment_text;
    public $model;
    public $user;
    public $useremail;
    public $username;
    public $commentIdReply;

    public function commentId($commentId)
    {
        $this->commentIdReply = $commentId;
    }

    public function resetCommentId()
    {
        $this->comment_text = '';
        $this->commentIdReply = NULL;
    }

    public function store(int $commentId = null)
    {
        if ($this->user) {

        $this->validate(['comment_text' => 'required']);

        }
        else {

        $this->validate([
            'comment_text' => 'required',
            'username' => 'required',
            'useremail' => 'required',
        ]);

        }

        $this->model->comments()->create([
           'comment' => preg_replace('#<h([1-6]).*?>(.*?)<\/h[1-6]>#si', '<p class="text-md">${2}</p>', $this->comment_text),
           'user_id' => $this->user,
           'parent_id' => $this->commentIdReply,
           // 'commentable_id' => $this->post_id,
           // 'commentable_type' => $this->commentable_type,
           'useremail' => $this->useremail,
           'username' => $this->username,
           'created_at' => Carbon::now()->format('d/m/Y H:m:s'),
       ]);

       $this->model->refresh();

       session()->flash('message', 'комментарий добавлен');

       $this->reset([
           'comment_text',
           'commentIdReply'
       ]);

    }

    public function render()
    {
        // $comments = Comment::with('replies','user')->parent()->where('commentable_type', $this->commentable_type)->where('commentable_id', $this->rating)->orderBy('created_at', 'desc')->paginate(50);

        return view('livewire.comments');
    }
}

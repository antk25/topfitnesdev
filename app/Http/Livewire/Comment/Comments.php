<?php

namespace App\Http\Livewire\Comment;

use Livewire\Component;
use App\Models\Comment;

use App\Models\User;
use Carbon\Carbon;

class Comments extends Component
{
    public $comment;
    public $model;
    public $post_id;
    public $commentable_type;
    public $user;
    public $useremail;
    public $username;
    public $commentIdReply = '';

    protected $rules = [
     'comment' => 'required',
    ];

    public function resetInputFields()
    {
        $this->comment = '';
        $this->commentIdReply = '';
    }

    public function store()
    {
        $this->validate();
        $this->model->comments()->create([
           'comment' => preg_replace('#<h([1-6]).*?>(.*?)<\/h[1-6]>#si', '<p class="text-md">${2}</p>', $this->comment),
           'user_id' => $this->user,
           // 'commentable_id' => $this->post_id,
           // 'commentable_type' => $this->commentable_type,
           'useremail' => $this->useremail,
           'username' => $this->username,
           'created_at' => Carbon::now()->format('d/m/Y H:m:s'),

       ]);

       $this->model->refresh();

       session()->flash('message', 'комментарий добавлен');

       $this->resetInputFields();
    }

    public function commentId($commentId)
    {
        $this->commentIdReply = $commentId;
    }

    public function replyStore($commentId)
    {
        $this->validate();
        
        $this->model->comments()->create([
           'comment' => preg_replace('#<h([1-6]).*?>(.*?)<\/h[1-6]>#si', '<p class="text-md">${2}</p>', $this->comment),
           'parent_id' => $this->commentIdReply,
           'user_id' => $this->user,
           // 'commentable_id' => $this->post_id,
           // 'commentable_type' => $this->commentable_type,
           'useremail' => $this->useremail,
           'username' => $this->username,
           'created_at' => Carbon::now()->format('d/m/Y H:m:s'),
       ]);
       
       $this->commentIdReply = '';

       $this->model->refresh();

       session()->flash('message', 'Ваш ответ на комментарий добавлен');

       $this->resetInputFields();

    }

    public function render()
    {
        // $comments = Comment::with('replies','user')->parent()->where('commentable_type', $this->commentable_type)->where('commentable_id', $this->rating)->orderBy('created_at', 'desc')->paginate(50);

        return view('livewire.comments');
    }
}

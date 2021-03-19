<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Rating;

use App\Models\User;

class Comments extends Component
{
    public $comment, $post_id, $commentable_type, $user, $rating;
    public $commentIdReply = null;

    public function mount($user, $rating)

    {
        $this->user = $user;
        $this->rating = $rating;
    }

    public function resetInputFields()
    {
        $this->comment = '';
    }

    public function store()
    {
        Comment::create([
           'comment' => $this->comment,
           'user_id' => $this->user,
           'commentable_id' => $this->post_id,
           'commentable_type' => $this->commentable_type
       ]);
       session()->flash('message', 'комментарий добавлен');
       $this->resetInputFields();

    }
    public function commentId($commentId) 
    {
        $this->commentIdReply = $commentId;
    }
    public function replyStore($commentId)
    {
        Comment::create([
           'comment' => $this->comment,
           'parent_id' => $this->commentIdReply,
           'user_id' => $this->user,
           'commentable_id' => $this->post_id,
           'commentable_type' => $this->commentable_type,
       ]);
       $this->commentIdReply = '';
       session()->flash('message', 'Ваш ответ на комментарий добавлен');
       $this->resetInputFields();

    }

    public function render()
    {
        $comments = Comment::with('replies','user')->parent()->where('commentable_type', $this->commentable_type)->where('commentable_id', $this->rating)->orderBy('created_at', 'desc')->paginate(50);
        return view('livewire.comments', compact('comments'));
    }
}

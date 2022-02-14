<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Carbon;

class Comments extends Component
{
    public $comment_text;
    public $model;
    public $user;
    public $users;
    public $useremail;
    public $created_at;
    public $username;
    public $commentIdReply;

    public function mount()
    {
        $this->created_at = Carbon::now()->format('d/m/Y H:m:s');
    }

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
           'useremail' => $this->useremail,
           'username' => $this->username,
           'created_at' => $this->created_at,
       ]);

       $this->model->refresh();

       session()->flash('message', 'комментарий добавлен');

       $this->reset();

    }

    public function render()
    {
        return view('livewire.admin.comments');
    }
}

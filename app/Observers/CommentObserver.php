<?php

namespace App\Observers;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewCommentNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {

       $admins = User::where('is_admin', 1)->get();

       Notification::send($admins, new NewCommentNotification($comment));
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
       $this->setPublishedAt($comment);
    }

    /**
     * Handle the Comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }

    protected function setPublishedAt (Comment $comment)
    {
        if ($comment->published_at == null && $comment->is_published) {

            $comment->published_at = Carbon::now()->format('d/m/Y');
        }
    }
}

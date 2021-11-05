<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;


class NotifyAdminComposer {

    public function compose(View $view) {

        $notifications = auth()->user()->unreadNotifications;

        return $view->with('notifications', $notifications);
    }
}
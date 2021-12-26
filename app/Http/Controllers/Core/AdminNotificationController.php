<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
   public function index() {

    $notifs = auth()->user()->unreadNotifications;

    return view('admin.notify', compact('notifs'));

   }

   public function markNotification(Request $request) {

    auth()->user()
    ->unreadNotifications
    ->when($request->input('id'), function ($query) use ($request) {
        return $query->where('id', $request->input('id'));
    })
    ->markAsRead();

    return back();

    // return response()->noContent();

   }
}

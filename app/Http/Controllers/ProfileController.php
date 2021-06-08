<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;
use App\Models\Rating;
use Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index() {

    $user = User::with('comments')->where('id', \Auth::user()->id)->first();

    if(\Gate::check('view-admin-panel'))
        {
        return view('admin.account', compact('user'));
        }
    return view('profile.index', compact('user'));

    }
}

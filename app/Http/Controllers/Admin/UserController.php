<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   public function create() 
   {
       return view('auth.register');
   }

   public function login()
   {
       return view('auth.login');
   }

   public function logout()
   {
       Auth::logout();
       
       return redirect()->route('login.user');
   }

   public function account()
   {
       return view('admin.account');
   }
}

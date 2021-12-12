<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
   public function __construct()
   {
       $this->middleware('guest');
   }

   /**
     * Форма регистрации
   */
   public function register()
   {
       return view('auth.register');
   }

   public function create(Request $request)
   {
       $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|string|email|max:255|unique:users',
           'password' => 'required|string|min:8|confirmed',
       ]);

       $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password)
       ]);

       if (isset($request->avatar)) {
           $user->addMediaFromRequest('avatar')->toMediaCollection('avatars');
       }

       if($user) {
           auth('web')->login($user);
       }

       return redirect(route('index'));

   }
}

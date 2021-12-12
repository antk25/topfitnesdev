<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct() {

        $this->middleware('guest', ['except' => 'logout']);

    }

    /**
     * Форма входа в личный кабинет
     */
    public function login() {
        return view('auth.login');
    }

     /**
     * Обработка попыток аутентификации.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request) {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {

            $request->session()->regenerate();

            return redirect()->intended(route('index'))->with('success', 'Вы успешно вошли на сайт');
        }

        return back()->withErrors([
            'email' => 'Неверный логин или пароль',
        ]);
    }

    /**
    * Выход пользователя из приложения.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function logout(Request $request) {

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('index'));

    }

}

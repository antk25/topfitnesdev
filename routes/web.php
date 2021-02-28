<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
// авторизация-регистрация
Route::name('user.')->group(function () {

    Route::view('/private', 'private')->middleware('auth')->name('private');

    Route::get('/login', function() {
        if(Auth::check()){
            return redirect(route('user.private'));
        }
        return view('auth.login');
    })->name('login');

    Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login');

    Route::get('/logout', function(){
        Auth::logout();
        return redirect('/');
    })->name('logout');

    Route::get('/registration', function() {
        if(Auth::check()){
            return redirect(route('user.private'));
        }
        return view('auth.registration');
    })->name('registration');

    Route::post('/registration', 'App\Http\Controllers\Auth\RegisterController@save');
});

// шаблоны страниц

Route::get('bracelets', 'App\Http\Controllers\BraceletsController@index')->name('bracelets.index');

Route::get('bracelets/{slug}', 'App\Http\Controllers\BraceletsController@show')->name('bracelets.show');

Route::post('/bracelets/{bracelet}/review', 'App\Http\Controllers\ReviewsController@store');

Route::get('/bracelets/{bracelet}/reviews', 'App\Http\Controllers\ReviewsController@index');

// Админка

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::get('/', 'MainController@index')->name('admin.index');
    Route::resource('/brands', 'BrandsController');
    Route::resource('/bracelets', 'BraceletsController');
    Route::resource('/ratings', 'RatingsController');
    Route::resource('/grades', 'GradesController');
});
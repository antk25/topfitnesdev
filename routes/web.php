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
    return view('private');
})->middleware(['auth']);
// авторизация-регистрация

// шаблоны страниц

Route::get('katalog', 'App\Http\Controllers\BraceletsController@index')->name('pub.bracelets.index');

Route::get('podbor', 'App\Http\Controllers\BraceletsController@selection')->name('pub.bracelets.selection');

Route::get('katalog/{slug}', 'App\Http\Controllers\BraceletsController@show')->name('bracelets.show');

Route::get('ratings', 'App\Http\Controllers\RatingsController@index')->name('pub.ratings.index');

Route::get('/{slug}', 'App\Http\Controllers\RatingsController@show')->name('pub.ratings.show');

Route::post('/katalog/{bracelet}/review', 'App\Http\Controllers\ReviewsController@store');

Route::get('/katalog/{bracelet}/reviews', 'App\Http\Controllers\ReviewsController@index');

// Админка

Route::middleware('auth')->prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::get('/', 'MainController@index')->name('admin.index');
    Route::resource('/brands', 'BrandsController');
    Route::resource('/bracelets', 'BraceletsController');
    Route::resource('/ratings', 'RatingsController');
    Route::resource('/grades', 'GradesController');
    Route::resource('/sellers', 'SellersController');
    Route::resource('/reviews', 'ReviewsController');
    Route::resource('/posts', 'PostsController');
    Route::post('/posts/delimg', 'PostsController@imgdelete')->name('posts.delimg');
    Route::post('/posts/updimg', 'PostsController@imgupdate')->name('posts.updimg');
    Route::post('/bracelets/delimg', 'BraceletsController@imgdelete')->name('bracelets.delimg');
    Route::post('/bracelets/updimg', 'BraceletsController@imgupdate')->name('bracelets.updimg');
    Route::resource('/comments', 'CommentsController');
    Route::post('/comments/reply', 'CommentsController@replyStore')->name('comments.reply');
});

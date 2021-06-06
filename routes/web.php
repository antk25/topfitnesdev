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

// обновление и просмотр профиля пользователя

Route::view('/profile/edit', 'profile.edit')->name('profile.edit')->middleware('auth');
Route::view('/profile/password', 'profile.password')->name('profile.password')->middleware('auth');
Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile.index')->middleware('auth');

// шаблоны страниц

Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');

Route::get('katalog', 'App\Http\Controllers\BraceletsController@index')->name('pub.bracelets.index');

Route::get('podbor', 'App\Http\Controllers\BraceletsController@selection')->name('pub.bracelets.selection');

Route::get('katalog/{slug}', 'App\Http\Controllers\BraceletsController@show')->name('bracelets.show');

Route::get('ratings', 'App\Http\Controllers\RatingsController@index')->name('pub.ratings.index');

Route::get('/{slug}', 'App\Http\Controllers\RatingsController@show')->name('pub.ratings.show');

Route::get('/blog/{slug}', 'App\Http\Controllers\PostsController@show')->name('pub.posts.show');

Route::post('/katalog/{bracelet}/review', 'App\Http\Controllers\ReviewsController@store');

Route::get('/katalog/{bracelet}/reviews', 'App\Http\Controllers\ReviewsController@index');

Route::post('/reply/store', 'App\Http\Controllers\CommentsController@replyStore')->name('reply.add');


// Админка

Route::middleware('auth')->prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::resource('/brands', 'BrandsController');
    Route::resource('/bracelets', 'BraceletsController');
    Route::get('/gradeupdate', 'BraceletsController@gradeUpdate')->name('bracelets.updategrades');
    Route::get('/import', 'BraceletsController@import');
    Route::post('importExcel', 'BraceletsController@importExcel');
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

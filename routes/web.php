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

Route::get('bracelets', 'App\Http\Controllers\BraceletsController@index')->name('bracelets.index');

Route::get('bracelets/{slug}', 'App\Http\Controllers\BraceletsController@show')->name('bracelets.show');

Route::post('/bracelets/{bracelet}/review', 'App\Http\Controllers\ReviewsController@store');

Route::get('/bracelets/{bracelet}/reviews', 'App\Http\Controllers\ReviewsController@index');

// Админка

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Admin'], function () {
    Route::get('/', 'MainController@index')->name('admin.index');
    Route::resource('/brands', 'BrandsController')->middleware(['auth']);
    Route::resource('/bracelets', 'BraceletsController');
    Route::resource('/ratings', 'RatingsController');
    Route::resource('/grades', 'GradesController');
    Route::resource('/sellers', 'SellersController');
    Route::resource('/reviews', 'ReviewsController');
    Route::resource('/posts', 'PostsController');
});

Route::post('admin/posts/delimg', 'App\Http\Controllers\Admin\PostsController@imgdelete')->name('posts.delimg');
Route::post('admin/posts/updimg', 'App\Http\Controllers\Admin\PostsController@imgupdate')->name('posts.updimg');
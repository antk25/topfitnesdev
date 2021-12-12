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

// Авторизация, регистрация, ЛК

// форма входа
Route::get('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
// аутентификация
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@authenticate')->name('auth');

// выход
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// форма регистрации
Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register');
// создание пользователя
Route::post('/register', 'App\Http\Controllers\Auth\RegisterController@create')->name('create');

// форма ввода адреса почты
Route::get('/forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordController@form')->name('forgot-form');
// письмо на почту
Route::post('/forgot-password', 'App\Http\Controllers\Auth\ForgotPasswordController@mail')->name('forgot-mail');

// форма восстановления пароля
Route::get('/reset-password/token/{token}/email/{email}', 'App\Http\Controllers\Auth\ResetPasswordController@form')->name('reset-form');

// восстановление пароля
Route::post('/reset-password', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('reset-password');

// Просмотр профиля
Route::get('/profile', 'App\Http\Controllers\ProfileController@index')->name('profile.index');

// Редактирование профиля - пользователь
Route::get('/profile/edit', 'App\Http\Controllers\Auth\UpdateUserPorfileInformation@edit')->name('profile-edit');

Route::put('/profile/update', 'App\Http\Controllers\Auth\UpdateUserPorfileInformation@update')->name('update-user-profile');

// Редактирование профиля - админ
Route::get('admin/profile/edit', 'App\Http\Controllers\Auth\UpdateUserPorfileInformation@edit')->name('admin.profile.edit');

// шаблоны страниц
Route::get('/', 'App\Http\Controllers\IndexController@index')->name('index');
Route::get('/katalog', 'App\Http\Controllers\BraceletsController@index')->name('pub.bracelets.index');
Route::get('/podbor', 'App\Http\Controllers\BraceletsController@selection')->name('pub.bracelets.selection');
Route::get('/katalog/{slug}', 'App\Http\Controllers\BraceletsController@show')->name('bracelets.show');
Route::get('/ratings', 'App\Http\Controllers\RatingsController@index')->name('pub.ratings.index');
Route::get('/{slug}', 'App\Http\Controllers\RatingsController@show')->name('pub.ratings.show');
Route::get('/blog/{slug}', 'App\Http\Controllers\PostsController@show')->name('pub.posts.show');
Route::post('/katalog/{bracelet}/review', 'App\Http\Controllers\ReviewsController@store');
Route::get('/katalog/{bracelet}/reviews', 'App\Http\Controllers\ReviewsController@index');
Route::post('/reply/store', 'App\Http\Controllers\CommentsController@replyStore')->name('reply.add');

// Админка

Route::middleware('can:view-admin-panel')->prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    // Редактирование профиля - админ
    Route::get('/dashboard', 'MainController')->name('dashboard');
    Route::get('/pages', 'TypePagesController@index')->name('pages');
    Route::get('/notifications', 'NotificationsController@index')->name('notifications');
    Route::post('/notifications/mark', 'NotificationsController@markNotification')->name('notifications.markNotification');
    Route::resource('/brands', 'BrandsController');
    Route::post('/brands/import', 'BrandsController@import')->name('brands.import');
    Route::resource('/specs', 'SpecsController');
    Route::post('/specs/import', 'SpecsController@import')->name('specs.import');
    Route::resource('/bracelets', 'BraceletsController');
    Route::get('/bracelet/restore/{bracelet}', 'BraceletsController@restore')->name('bracelets.restore');
    Route::get('/gradeupdate', 'BraceletsController@gradeUpdate')->name('bracelets.updategrades');
    Route::post('/import', 'BraceletsController@import')->name('bracelets.import');
    Route::post('importExcel', 'BraceletsController@importExcel');
    Route::resource('/ratings', 'RatingsController');
    Route::resource('/menuitems', 'MenuItemsController');
    Route::resource('/groupmenus', 'GroupMenusController');
    Route::resource('/grades', 'GradesController');
    Route::resource('/sellers', 'SellersController');
    Route::resource('/reviews', 'ReviewsController');
    Route::resource('/posts', 'PostsController');
    Route::resource('/htmlcomponents', 'HtmlComponentsController');
    Route::post('/posts/delimg', 'PostsController@imgdelete')->name('posts.delimg');
    Route::post('/posts/updimg', 'PostsController@imgupdate')->name('posts.updimg');
    Route::resource('/comparisons', 'ComparisonsController');
    Route::post('/comparisons/delimg', 'ComparisonsController@imgdelete')->name('comparisons.delimg');
    Route::post('/comparisons/updimg', 'ComparisonsController@imgupdate')->name('comparisons.updimg');
    Route::resource('/manuals', 'ManualsController');
    Route::post('/manuals/delimg', 'ManualsController@imgdelete')->name('manuals.delimg');
    Route::post('/manuals/updimg', 'ManualsController@imgupdate')->name('manuals.updimg');
    Route::resource('/compareitems', 'CompareItemsController');
    Route::post('/compareitems/delimg', 'CompareItemsController@imgdelete')->name('compareitems.delimg');
    Route::post('/compareitems/updimg', 'CompareItemsController@imgupdate')->name('compareitems.updimg');
    Route::resource('/overviews', 'OverviewsController');
    Route::post('/overviews/delimg', 'OverviewsController@imgdelete')->name('overviews.delimg');
    Route::post('/overviews/updimg', 'OverviewsController@imgupdate')->name('overviews.updimg');
    Route::post('/bracelets/delimg', 'BraceletsController@imgdelete')->name('bracelets.delimg');
    Route::post('/bracelets/updimg', 'BraceletsController@imgupdate')->name('bracelets.updimg');
    Route::resource('/comments', 'CommentsController');
    Route::post('/comments/reply', 'CommentsController@replyStore')->name('comments.reply');
});


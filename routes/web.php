<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ComponentsPageController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\SettingsPageController;
use App\Http\Controllers\Admin\SpecController;
use App\Http\Controllers\Admin\TypePageController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UpdateUserPorfileInformation;
use App\Http\Controllers\BraceletController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Core\GroupMenuController;
use App\Http\Controllers\Core\MenuItemController;
use App\Http\Controllers\IndexController as IndexController;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReviewController;
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

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('create');
Route::get('/forgot-password', [ForgotPasswordController::class, 'form'])->name('forgot-form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'mail'])->name('forgot-mail');
Route::get('/reset-password/token/{token}/email/{email}', [ResetPasswordController::class, 'form'])->name('reset-form');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('reset-password');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [UpdateUserPorfileInformation::class, 'edit'])->name('profile-edit');
Route::put('/profile/update', [UpdateUserPorfileInformation::class, 'update'])->name('update-user-profile');
Route::get('admin/profile/edit', [UpdateUserPorfileInformation::class, 'edit'])->name('admin.profile.edit');

// шаблоны страниц
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/katalog', [BraceletController::class, 'index'])->name('pub.bracelets.index');
Route::get('/podbor', [BraceletController::class, 'selection'])->name('pub.bracelets.selection');
Route::get('/katalog/{slug}', [BraceletController::class, 'show'])->name('pub.bracelets.show');
Route::get('/ratings', [RatingController::class, 'index'])->name('pub.ratings.index');
Route::get('/{slug}', [RatingController::class, 'show'])->name('pub.ratings.show');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('pub.posts.show');
Route::post('/katalog/{bracelet}/review', [ReviewController::class, 'store']);
Route::get('/katalog/{bracelet}/reviews', [ReviewController::class, 'index']);
Route::post('/reply/store', [CommentController::class, 'replyStore'])->name('reply.add');




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
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
// аутентификация
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'authenticate'])->name('auth');

// выход
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// форма регистрации
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
// создание пользователя
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('create');

// форма ввода адреса почты
Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'form'])->name('forgot-form');
// письмо на почту
Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'mail'])->name('forgot-mail');

// форма восстановления пароля
Route::get('/reset-password/token/{token}/email/{email}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'form'])->name('reset-form');

// восстановление пароля
Route::post('/reset-password', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('reset-password');

// Просмотр профиля
Route::get('/profile', [\App\Http\Controllers\Auth\ProfileController::class, 'index'])->name('profile.index');

// Редактирование профиля - пользователь
Route::get('/profile/edit', [\App\Http\Controllers\Auth\UpdateUserPorfileInformation::class, 'edit'])->name('profile-edit');

Route::put('/profile/update', [\App\Http\Controllers\Auth\UpdateUserPorfileInformation::class, 'update'])->name('update-user-profile');

// Редактирование профиля - админ
Route::get('admin/profile/edit', [\App\Http\Controllers\Auth\UpdateUserPorfileInformation::class, 'edit'])->name('admin.profile.edit');

// шаблоны страниц
Route::get('/', [\App\Http\Controllers\Core\IndexController::class, 'index'])->name('index');
Route::get('/katalog', [\App\Http\Controllers\Products\BraceletController::class, 'index'])->name('pub.bracelets.index');
Route::get('/podbor', [\App\Http\Controllers\Products\BraceletController::class, 'selection'])->name('pub.bracelets.selection');
Route::get('/katalog/{slug}', [\App\Http\Controllers\Products\BraceletController::class, 'show'])->name('bracelets.show');
Route::get('/ratings', [\App\Http\Controllers\Rating\RatingController::class, 'index'])->name('pub.ratings.index');
Route::get('/{slug}', [\App\Http\Controllers\Rating\RatingController::class, 'show'])->name('pub.ratings.show');
Route::get('/blog/{slug}', [\App\Http\Controllers\Blog\PostController::class, 'show'])->name('pub.posts.show');
Route::post('/katalog/{bracelet}/review', [\App\Http\Controllers\Review\ReviewController::class, 'store']);
Route::get('/katalog/{bracelet}/reviews', [\App\Http\Controllers\Review\ReviewController::class, 'index']);
Route::post('/reply/store', [\App\Http\Controllers\Comment\CommentController::class, 'replyStore'])->name('reply.add');

// Админка

Route::middleware('can:view-admin-panel')->prefix('admin')->group(function () {
    // Редактирование профиля - админ
    Route::get('/dashboard', \App\Http\Controllers\Core\AdminIndexController::class)->name('dashboard');

    Route::get('/pages', [\App\Http\Controllers\Core\AdminTypePageController::class, 'index'])->name('pages');

    Route::get('/components', [\App\Http\Controllers\Core\AdminComponentsPageController::class, 'index'])->name('components');

    Route::get('/settings', [\App\Http\Controllers\Core\AdminSettingsPageController::class, 'index'])->name('settings');

    Route::get('/notifications', [\App\Http\Controllers\Core\AdminNotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark', [\App\Http\Controllers\Core\AdminNotificationController::class, 'markNotification'])->name('notifications.markNotification');

    Route::resource('/brands', \App\Http\Controllers\Products\AdminBrandController::class);
    Route::post('/brands/import', [\App\Http\Controllers\Products\AdminBrandController::class, 'import'])->name('brands.import');

    Route::resource('/specs', \App\Http\Controllers\Products\AdminSpecController::class);
    Route::post('/specs/import', [\App\Http\Controllers\Products\AdminSpecController::class, 'import'])->name('specs.import');

    Route::resource('/bracelets', \App\Http\Controllers\Products\AdminBraceletController::class);
    Route::get('/bracelet/restore/{bracelet}', [\App\Http\Controllers\Products\AdminBraceletController::class, 'restore'])->name('bracelets.restore');

    Route::get('/gradeupdate', [\App\Http\Controllers\Products\AdminBraceletController::class, 'gradeUpdate'])->name('bracelets.updategrades');
    Route::post('/import', [\App\Http\Controllers\Products\AdminBraceletController::class, 'import'])->name('bracelets.import');

    Route::resource('/menuitems', \App\Http\Controllers\Core\MenuItemController::class);
    Route::resource('/groupmenus', \App\Http\Controllers\Core\GroupMenuController::class);
    Route::resource('/grades', \App\Http\Controllers\Products\AdminGradeController::class);
    Route::resource('/sellers', \App\Http\Controllers\Products\AdminSellerController::class);
    Route::resource('/reviews', \App\Http\Controllers\Review\AdminReviewController::class);

    Route::resource('/ratings', \App\Http\Controllers\Rating\AdminRatingController::class);
    Route::get('/rating/restore/{rating}', [\App\Http\Controllers\Rating\AdminRatingController::class, 'restore'])->name('ratings.restore');
    Route::get('/rating/publish/{rating}', [\App\Http\Controllers\Rating\AdminRatingController::class, 'publish'])->name('ratings.publish');
    Route::post('/ratings/delimg', [\App\Http\Controllers\Rating\AdminRatingController::class, 'imgdelete'])->name('ratings.delimg');
    Route::post('/ratings/updimg', [\App\Http\Controllers\Rating\AdminRatingController::class, 'imgupdate'])->name('ratings.updimg');

    Route::resource('/posts', \App\Http\Controllers\Blog\AdminPostController::class);
    Route::get('/post/restore/{post}', [\App\Http\Controllers\Blog\AdminPostController::class, 'restore'])->name('posts.restore');
    Route::get('/post/publish/{post}', [\App\Http\Controllers\Blog\AdminPostController::class, 'publish'])->name('posts.publish');
    Route::post('/posts/delimg', [\App\Http\Controllers\Blog\AdminPostController::class, 'imgdelete'])->name('posts.delimg');
    Route::post('/posts/updimg', [\App\Http\Controllers\Blog\AdminPostController::class, 'imgupdate'])->name('posts.updimg');

    Route::resource('/comparisons', \App\Http\Controllers\Comparison\AdminComparisonController::class);
    Route::get('/comparison/restore/{comparison}', [\App\Http\Controllers\Comparison\AdminComparisonController::class, 'restore'])->name('comparisons.restore');
    Route::get('/comparison/publish/{comparison}', [\App\Http\Controllers\Comparison\AdminComparisonController::class, 'publish'])->name('comparisons.publish');
    Route::post('/comparisons/delimg', [\App\Http\Controllers\Comparison\AdminComparisonController::class, 'imgdelete'])->name('comparisons.delimg');
    Route::post('/comparisons/updimg', [\App\Http\Controllers\Comparison\AdminComparisonController::class, 'imgupdate'])->name('comparisons.updimg');

    Route::resource('/manuals', \App\Http\Controllers\Manual\AdminManualController::class);
    Route::get('/manual/restore/{manual}', [\App\Http\Controllers\Manual\AdminManualController::class, 'restore'])->name('manuals.restore');
    Route::get('/manual/publish/{manual}', [\App\Http\Controllers\Manual\AdminManualController::class, 'publish'])->name('manuals.publish');
    Route::post('/manuals/delimg', [\App\Http\Controllers\Manual\AdminManualController::class, 'imgdelete'])->name('manuals.delimg');
    Route::post('/manuals/updimg', [\App\Http\Controllers\Manual\AdminManualController::class, 'imgupdate'])->name('manuals.updimg');

    Route::resource('/overviews', \App\Http\Controllers\Overview\AdminOverviewController::class);
    Route::get('/overview/restore/{overview}', [\App\Http\Controllers\Overview\AdminOverviewController::class, 'restore'])->name('overviews.restore');
    Route::get('/overview/publish/{overview}', [\App\Http\Controllers\Overview\AdminOverviewController::class, 'publish'])->name('overviews.publish');
    Route::post('/overviews/delimg', [\App\Http\Controllers\Overview\AdminOverviewController::class, 'imgdelete'])->name('overviews.delimg');
    Route::post('/overviews/updimg', [\App\Http\Controllers\Overview\AdminOverviewController::class, 'imgupdate']);

    Route::post('/bracelets/delimg', [\App\Http\Controllers\Products\AdminBraceletController::class, 'imgdelete'])->name('bracelets.delimg');
    Route::post('/bracelets/updimg', [\App\Http\Controllers\Products\AdminBraceletController::class, 'imgupdate'])->name('bracelets.updimg');
    Route::resource('/comments', \App\Http\Controllers\Comment\AdminCommentController::class);
    Route::post('/comments/reply', [\App\Http\Controllers\Comment\AdminCommentController::class, 'replyStore'])->name('comments.reply');
    Route::resource('/htmlcomponents', \App\Http\Controllers\Core\AdminHtmlComponentController::class);
});


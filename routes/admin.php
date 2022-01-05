<?php

use App\Http\Controllers\Admin\BraceletController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ComparisonController;
use App\Http\Controllers\Admin\ComponentsPageController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\HtmlComponentController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ManualController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OverviewController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RatingController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SellerController;
use App\Http\Controllers\Admin\SettingsPageController;
use App\Http\Controllers\Admin\SpecController;
use App\Http\Controllers\Admin\TypePageController;
use App\Http\Controllers\Core\GroupMenuController;
use App\Http\Controllers\Core\MenuItemController;

Route::middleware('can:view-admin-panel')->prefix('admin')->group(function () {
// Редактирование профиля - админ
Route::get('/dashboard', IndexController::class)->name('dashboard');

Route::get('/pages', [TypePageController::class, 'index'])->name('pages');

Route::get('/components', [ComponentsPageController::class, 'index'])->name('components');

Route::get('/settings', [SettingsPageController::class, 'index'])->name('settings');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/mark', [NotificationController::class, 'markNotification'])->name('notifications.markNotification');

Route::resource('/brands', BrandController::class);
Route::post('/brands/import', [BrandController::class, 'import'])->name('brands.import');

Route::resource('/specs', SpecController::class);
Route::post('/specs/import', [SpecController::class, 'import'])->name('specs.import');

Route::resource('/bracelets', BraceletController::class);
Route::get('/bracelet/restore/{bracelet}', [BraceletController::class, 'restore'])->name('bracelets.restore');

Route::get('/gradeupdate', [BraceletController::class, 'gradeUpdate'])->name('bracelets.updategrades');
Route::post('/import', [BraceletController::class, 'import'])->name('bracelets.import');

Route::resource('/menuitems', MenuItemController::class);
Route::resource('/groupmenus', GroupMenuController::class);
Route::resource('/grades', GradeController::class);
Route::resource('/sellers', SellerController::class);
Route::resource('/reviews', ReviewController::class);

Route::resource('/ratings', RatingController::class);
Route::get('/rating/restore/{rating}', [RatingController::class, 'restore'])->name('ratings.restore');
Route::get('/rating/publish/{rating}', [RatingController::class, 'publish'])->name('ratings.publish');
Route::post('/ratings/delimg', [RatingController::class, 'imgdelete'])->name('ratings.delimg');
Route::post('/ratings/updimg', [RatingController::class, 'imgupdate'])->name('ratings.updimg');

Route::resource('/posts', PostController::class);
Route::get('/post/restore/{post}', [PostController::class, 'restore'])->name('posts.restore');
Route::get('/post/publish/{post}', [PostController::class, 'publish'])->name('posts.publish');
Route::post('/posts/delimg', [PostController::class, 'imgdelete'])->name('posts.delimg');
Route::post('/posts/updimg', [PostController::class, 'imgupdate'])->name('posts.updimg');

Route::resource('/comparisons', ComparisonController::class);
Route::get('/comparison/restore/{comparison}', [ComparisonController::class, 'restore'])->name('comparisons.restore');
Route::get('/comparison/publish/{comparison}', [ComparisonController::class, 'publish'])->name('comparisons.publish');
Route::post('/comparisons/delimg', [ComparisonController::class, 'imgdelete'])->name('comparisons.delimg');
Route::post('/comparisons/updimg', [ComparisonController::class, 'imgupdate'])->name('comparisons.updimg');

Route::resource('/manuals', ManualController::class);
Route::get('/manual/restore/{manual}', [ManualController::class, 'restore'])->name('manuals.restore');
Route::get('/manual/publish/{manual}', [ManualController::class, 'publish'])->name('manuals.publish');
Route::post('/manuals/delimg', [ManualController::class, 'imgdelete'])->name('manuals.delimg');
Route::post('/manuals/updimg', [ManualController::class, 'imgupdate'])->name('manuals.updimg');

Route::resource('/overviews', OverviewController::class);
Route::get('/overview/restore/{overview}', [OverviewController::class, 'restore'])->name('overviews.restore');
Route::get('/overview/publish/{overview}', [OverviewController::class, 'publish'])->name('overviews.publish');
Route::post('/overviews/delimg', [OverviewController::class, 'imgdelete'])->name('overviews.delimg');
Route::post('/overviews/updimg', [OverviewController::class, 'imgupdate']);

Route::post('/bracelets/delimg', [BraceletController::class, 'imgdelete'])->name('bracelets.delimg');
Route::post('/bracelets/updimg', [BraceletController::class, 'imgupdate'])->name('bracelets.updimg');
Route::resource('/comments', CommentController::class);
Route::post('/comments/reply', [CommentController::class, 'replyStore'])->name('comments.reply');
Route::resource('/htmlcomponents', HtmlComponentController::class);
});

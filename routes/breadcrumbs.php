<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

/**
 * Web
 */

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('index'));
});

// Home > Rating
Breadcrumbs::for('rating', function (BreadcrumbTrail $trail, $rating) {
    $trail->parent('home');
    $trail->push($rating->name, route('pub.ratings.show', ['slug' => $rating->slug]));
});

// Home > Catalog
Breadcrumbs::for('katalog', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Каталог', route('pub.bracelets.index'));
});

// Home > Catalog > Bracelet
Breadcrumbs::for('bracelet', function (BreadcrumbTrail $trail, $bracelet) {
    $trail->parent('katalog');
    $trail->push($bracelet->name, route('pub.bracelets.show', ['slug' => $bracelet->slug]));
});



/**
 * Admin Panel
 */

// Admin
Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->push('Админка', route('dashboard'));
});

// Уведомления
Breadcrumbs::for('notifications', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Уведомления', route('notifications'));
});

/**
 * Admin Panel - Profile
 */

// Admin > Profile
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Профиль', route('profile.index'));
});

// Admin > Profile > Edit Profile
Breadcrumbs::for('admin_profile_edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('profile');
    $trail->push($user->name . " (id =  $user->id)", route('profile-edit', ['user' => $user->id]));
});

/**
 * Admin Panel - Settings
 */

// Settings
Breadcrumbs::for('settings', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Настройки', route('settings'));
});

// Admin > Settings > HtmlComponents
Breadcrumbs::for('htmlcomponents', function (BreadcrumbTrail $trail) {
    $trail->parent('settings');
    $trail->push('Компоненты HTML', route('htmlcomponents.index'));
});

// Admin > Settings > HtmlComponents > HtmlComponent
Breadcrumbs::for('admin_htmlcomponent', function (BreadcrumbTrail $trail, $htmlcomponent) {
    $trail->parent('htmlcomponents');
    $trail->push($htmlcomponent->name . " (id =  $htmlcomponent->id)", route('htmlcomponents.edit', ['htmlcomponent' => $htmlcomponent->id]));
});

// Admin > Settings > HtmlComponents > Create HtmlComponent
Breadcrumbs::for('admin_htmlcomponent_create', function (BreadcrumbTrail $trail) {
    $trail->parent('htmlcomponents');
    $trail->push("Создать HTML компонент", route('htmlcomponents.create'));
});

/**
 * Admin Panel - Pages
 */

// Pages
Breadcrumbs::for('pages', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Страницы', route('pages'));
});


// Admin > Pages > Bracelets
Breadcrumbs::for('admin_bracelets', function (BreadcrumbTrail $trail) {
    $trail->parent('pages');
    $trail->push('Браслеты', route('bracelets.index'));
});

// Admin > Pages > Bracelets > Bracelet
Breadcrumbs::for('admin_bracelet', function (BreadcrumbTrail $trail, $bracelet) {
    $trail->parent('admin_bracelets');
    $trail->push($bracelet->name . " (id =  $bracelet->id)", route('bracelets.edit', ['bracelet' => $bracelet->id]));
});

// Admin > Pages > Bracelets > Create Bracelet
Breadcrumbs::for('admin_bracelet_create', function (BreadcrumbTrail $trail) {
    $trail->parent('bracelets');
    $trail->push("Создать браслет", route('bracelets.create'));
});

// Admin > Pages > Ratings
Breadcrumbs::for('ratings', function (BreadcrumbTrail $trail) {
    $trail->parent('pages');
    $trail->push('Рейтинги', route('ratings.index'));
});

// Admin > Pages > Ratings > Rating
Breadcrumbs::for('admin_rating', function (BreadcrumbTrail $trail, $rating) {
    $trail->parent('ratings');
    $trail->push($rating->name . " (id =  $rating->id)", route('ratings.edit', ['rating' => $rating->id]));
});

// Admin > Pages > Ratings > Create Rating
Breadcrumbs::for('admin_rating_create', function (BreadcrumbTrail $trail) {
    $trail->parent('ratings');
    $trail->push("Создать рейтинг", route('ratings.create'));
});

// Admin > Pages > Posts
Breadcrumbs::for('posts', function (BreadcrumbTrail $trail) {
    $trail->parent('pages');
    $trail->push('Блог', route('posts.index'));
});

// Admin > Pages > Posts > Rating
Breadcrumbs::for('admin_post', function (BreadcrumbTrail $trail, $post) {
    $trail->parent('posts');
    $trail->push($post->name . " (id =  $post->id)", route('posts.edit', ['post' => $post->id]));
});

// Admin > Pages > Posts > Create Post
Breadcrumbs::for('admin_post_create', function (BreadcrumbTrail $trail) {
    $trail->parent('posts');
    $trail->push("Создать пост для блога", route('posts.create'));
});


// Admin > Pages > Overviews
Breadcrumbs::for('overviews', function (BreadcrumbTrail $trail) {
    $trail->parent('pages');
    $trail->push('Обзоры', route('overviews.index'));
});

// Admin > Pages > Overviews > Rating
Breadcrumbs::for('admin_overview', function (BreadcrumbTrail $trail, $overview) {
    $trail->parent('overviews');
    $trail->push($overview->name . " (id =  $overview->id)", route('overviews.edit', ['overview' => $overview->id]));
});

// Admin > Pages > Overviews > Create Post
Breadcrumbs::for('admin_overview_create', function (BreadcrumbTrail $trail) {
    $trail->parent('overviews');
    $trail->push("Создать обзор браслета", route('overviews.create'));
});


// Admin > Pages > Comparisons
Breadcrumbs::for('comparisons', function (BreadcrumbTrail $trail) {
    $trail->parent('pages');
    $trail->push('Сравнения', route('comparisons.index'));
});

// Admin > Pages > Comparisons > Comparison
Breadcrumbs::for('admin_comparison', function (BreadcrumbTrail $trail, $comparison) {
    $trail->parent('comparisons');
    $trail->push($comparison->name . " (id =  $comparison->id)", route('comparisons.edit', ['comparison' => $comparison->id]));
});

// Admin > Pages > Comparisons > Create Comparison
Breadcrumbs::for('admin_comparison_create', function (BreadcrumbTrail $trail) {
    $trail->parent('comparisons');
    $trail->push("Создать сравнение браслетов", route('comparisons.create'));
});


// Admin > Pages > Manuals
Breadcrumbs::for('manuals', function (BreadcrumbTrail $trail) {
    $trail->parent('pages');
    $trail->push('Мануалы', route('manuals.index'));
});

// Admin > Pages  > Manuals > Manual
Breadcrumbs::for('admin_manual', function (BreadcrumbTrail $trail, $manual) {
    $trail->parent('manuals');
    $trail->push($manual->name . " (id =  $manual->id)", route('manuals.edit', ['manual' => $manual->id]));
});

// Admin > Pages  > Manuals > Create Manual
Breadcrumbs::for('admin_manual_create', function (BreadcrumbTrail $trail) {
    $trail->parent('manuals');
    $trail->push("Создать мануал (инструкцию)", route('manuals.create'));
});

/**
 * Admin Panel - Components
 */

// Components
Breadcrumbs::for('components', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Компоненты', route('components'));
});

// Admin > Components > Grades
Breadcrumbs::for('grades', function (BreadcrumbTrail $trail) {
    $trail->parent('components');
    $trail->push('Оценки', route('grades.index'));
});

// Admin > Components  > Grades > Grade
Breadcrumbs::for('admin_grade', function (BreadcrumbTrail $trail, $grade) {
    $trail->parent('grades');
    $trail->push($grade->name . " (id =  $grade->id)", route('grades.edit', ['grade' => $grade->id]));
});

// Admin > Components  > Grades > Grade Create
Breadcrumbs::for('admin_grade_create', function (BreadcrumbTrail $trail) {
    $trail->parent('grades');
    $trail->push("Создать оценку", route('grades.create'));
});

// Admin > Components > Sellers
Breadcrumbs::for('sellers', function (BreadcrumbTrail $trail) {
    $trail->parent('components');
    $trail->push('Продавцы', route('sellers.index'));
});

// Admin > Components > Sellers > Seller
Breadcrumbs::for('admin_seller', function (BreadcrumbTrail $trail, $seller) {
    $trail->parent('sellers');
    $trail->push($seller->name . " (id =  $seller->id)", route('sellers.edit', ['seller' => $seller->id]));
});

// Admin > Components > Sellers > Seller Create
Breadcrumbs::for('admin_seller_create', function (BreadcrumbTrail $trail) {
    $trail->parent('sellers');
    $trail->push("Создать продавца", route('sellers.create'));
});


// Admin > Components > Reviews
Breadcrumbs::for('reviews', function (BreadcrumbTrail $trail) {
    $trail->parent('components');
    $trail->push('Отзывы', route('reviews.index'));
});

// Admin > Components > Reviews > Review
Breadcrumbs::for('admin_review', function (BreadcrumbTrail $trail, $review) {
    $trail->parent('reviews');
    $trail->push("id =  $review->id", route('reviews.edit', ['review' => $review->id]));
});

// Admin > Components > Reviews > Review Create
Breadcrumbs::for('admin_review_create', function (BreadcrumbTrail $trail) {
    $trail->parent('reviews');
    $trail->push("Создать отзыв", route('reviews.create'));
});


// Admin > Components > Comments
Breadcrumbs::for('comments', function (BreadcrumbTrail $trail) {
    $trail->parent('components');
    $trail->push('Комментарии', route('comments.index'));
});

// Admin > Components > Comments > Comment
Breadcrumbs::for('admin_comment', function (BreadcrumbTrail $trail, $comment) {
    $trail->parent('comments');
    $trail->push("id =  $comment->id", route('comments.edit', ['comment' => $comment->id]));
});

// Admin > Components > Comments > Comment Create
Breadcrumbs::for('admin_comment_create', function (BreadcrumbTrail $trail) {
    $trail->parent('comments');
    $trail->push("Создать комментарий", route('comments.create'));
});


// Admin > Components > Brands
Breadcrumbs::for('brands', function (BreadcrumbTrail $trail) {
    $trail->parent('components');
    $trail->push('Бренды', route('brands.index'));
});

// Admin > Components > Brands > Brand
Breadcrumbs::for('admin_brand', function (BreadcrumbTrail $trail, $brand) {
    $trail->parent('brands');
    $trail->push($brand->name . " (id =  $brand->id)", route('brands.edit', ['brand' => $brand->id]));
});

// Admin > Components > Brands > Brand Create
Breadcrumbs::for('admin_brand_create', function (BreadcrumbTrail $trail) {
    $trail->parent('brands');
    $trail->push("Создать бренд", route('brands.create'));
});

// Admin > Components > Specs
Breadcrumbs::for('specs', function (BreadcrumbTrail $trail) {
    $trail->parent('components');
    $trail->push('Характеристики', route('specs.index'));
});

// Admin > Components > Specs > Spec
Breadcrumbs::for('admin_spec', function (BreadcrumbTrail $trail, $spec) {
    $trail->parent('specs');
    $trail->push($spec->name . " (id =  $spec->id)", route('specs.edit', ['spec' => $spec->id]));
});

// Admin > Components > Specs > Spec Create
Breadcrumbs::for('admin_spec_create', function (BreadcrumbTrail $trail) {
    $trail->parent('specs');
    $trail->push("Создать характеристику", route('specs.create'));
});

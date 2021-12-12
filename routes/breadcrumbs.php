<?php

// Home

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Главная', route('index'));
});

// Home > Rating
Breadcrumbs::for('rating', function (BreadcrumbTrail $trail, $rating) {
    $trail->parent('home');
    $trail->push($rating->name, route('pub.ratings.show', ['slug' => $rating->slug]));
});


// Admin
Breadcrumbs::for('admin', function (BreadcrumbTrail $trail) {
    $trail->push('Админка', route('dashboard'));
});

// Pages
Breadcrumbs::for('pages', function (BreadcrumbTrail $trail) {
    $trail->parent('admin');
    $trail->push('Страницы', route('pages'));
});

// Admin > Pages > Bracelets
Breadcrumbs::for('bracelets', function (BreadcrumbTrail $trail) {
    $trail->parent('pages');
    $trail->push('Браслеты', route('bracelets.index'));
});

// Admin > Pages > Bracelets > Bracelet
Breadcrumbs::for('bracelet', function (BreadcrumbTrail $trail, $bracelet) {
    $trail->parent('bracelets');
    $trail->push($bracelet->name . " (id =  $bracelet->id)", route('bracelets.edit', ['bracelet' => $bracelet->id]));
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
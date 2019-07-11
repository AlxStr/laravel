<?php

use \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('admin.home', function ($trail) {
    $trail->push('Dashboard', route('admin.home'));
});

Breadcrumbs::for('login', function ($trail) {
    $trail->parent('home');
    $trail->push('Login', route('login'));
});

Breadcrumbs::for('register', function ($trail) {
    $trail->parent('home');
    $trail->push('Register', route('register'));
});

Breadcrumbs::for('password.request', function ($trail) {
    $trail->parent('login');
    $trail->push('Password Reset');
});

Breadcrumbs::for('cabinet', function ($trail) {
    $trail->parent('home');
    $trail->push('Cabinet', route('cabinet'));
});
//
//Breadcrumbs::for('category', function ($trail, $category) {
//    if ($category->parent) {
//        $trail->parent('category', $category->parent);
//    }
//    $trail->push($category->name, route('category'));
//});
//
//Breadcrumbs::for('advert', function ($trail, $advert) {
//    $trail->parent('region', $advert->region);
//    $trail->parent('category', $advert->category);
//    $trail->push($advert->name, route('category'));
//});

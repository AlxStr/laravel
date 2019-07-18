<?php

use App\Entity\Region;
use App\Entity\User;
use App\Entity\Adverts\Category;
use \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
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

/**
 * Admin
 */

Breadcrumbs::for('admin.home', function ($trail) {
    $trail->push('Dashboard', route('admin.home'));
});

/**
 * Admin/Users
 */
Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Users', route('admin.users.index'));
});

Breadcrumbs::for('admin.users.create', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Create', route('admin.users.create'));
});

Breadcrumbs::for('admin.users.show', function ($trail, User $user) {
    $trail->parent('admin.home');
    $trail->push($user->name, route('admin.users.show', $user));
});

Breadcrumbs::for('admin.users.edit', function ($trail, User $user) {
    $trail->parent('admin.home');
    $trail->push('Edit', route('admin.users.edit', $user));
});

/**
 * Admin/Regions
 */
Breadcrumbs::for('admin.regions.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Regions', route('admin.regions.index'));
});

Breadcrumbs::for('admin.regions.create', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Create', route('admin.regions.create'));
});

Breadcrumbs::for('admin.regions.show', function ($trail, Region $region) {
    if ($parent = $region->parent) {
        $trail->parent('admin.regions.show', $parent);
    } else {
        $trail->parent('admin.regions.index');
    }

    $trail->push($region->name, route('admin.regions.show', $region));
});

Breadcrumbs::for('admin.regions.edit', function ($trail, Region $region) {
    $trail->parent('admin.home');
    $trail->push('Edit', route('admin.regions.edit', $region));
});


/**
 * Admin/Adverts/Categories
 */
Breadcrumbs::for('admin.adverts.categories.index', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Regions', route('admin.adverts.categories.index'));
});

Breadcrumbs::for('admin.adverts.categories.create', function ($trail) {
    $trail->parent('admin.home');
    $trail->push('Create', route('admin.adverts.categories.create'));
});

Breadcrumbs::for('admin.adverts.categories.show', function ($trail, Category $category) {
//    if ($parent = $category->parent) {
//        $trail->parent('admin.adverts.categories.show', $category);
//    } else {
//        $trail->parent('admin.adverts.categories.index');
//    }

    $trail->push($category->name, route('admin.adverts.categories.show', $category));
});

Breadcrumbs::for('admin.adverts.categories.edit', function ($trail, Category $category) {
    $trail->parent('admin.home');
    $trail->push('Edit', route('admin.adverts.categories.edit', $category));
});

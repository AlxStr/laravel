<?php

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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

Route::get('/cabinet', 'Cabinet\CabinetController@index')->name('cabinet');


// Варіант 1
//Route::prefix('admin')->group(function () {
//    Route::middleware(['auth'])->group(function () {
//        Route::namespace('Admin')->group(function () {
//            Route::get('/', 'HomeController@index')->name('admin.home');
//            Route::resource('users', 'UsersController');
//        });
//    });
//});

//Варіант 2
Route::group(
    [
        'prefix'     => 'admin',
        'as'         => 'admin.',
        'namespace'  => 'Admin',
        'middleware' => ['auth']
    ],
    function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('users', 'UsersController');
    }
);



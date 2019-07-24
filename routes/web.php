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

# Landing page
Route::get('/', function () {
    return view('welcome');
});

# Authentication routes
Auth::routes();

# Application main page
Route::get('/home', 'App\HomeController@index')->name('home');

# Settings page.
Route::match(['get', 'post'], '/settings', 'App\HomeController@settings')->name('settings');

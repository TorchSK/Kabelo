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

Route::get('/', function () {
    return view('home');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/register', 'UserController@register')->name('register');
Route::any('/logout', 'UserController@logout')->name('logout');

Route::get('/user/activate/{token}', 'UserController@activate')->name('activateUser');
Route::post('/login', 'UserController@login')->name('login');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/category/{category_id}/products', 'AdminController@products');
Route::post('/file/upload', 'ProductController@upload');

Route::resource('category','CategoryController');
Route::resource('products','ProductController');
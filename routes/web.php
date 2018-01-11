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

//Cart
Route::put('cart/add/{productId}','CartController@addItem');
Route::get('cart/products','CartController@products');
Route::get('cart/delivery','CartController@delivery');
Route::get('cart/shipping','CartController@shipping');
Route::get('cart/confirm','CartController@confirm');

Route::delete('cart/all','CartController@delete');
Route::delete('cart/{productid}','CartController@deleteItem');
Route::put('cart/plus/{productid}','CartController@plusItem');
Route::put('cart/minus/{productid}','CartController@minusItem');
Route::post('cart','CartController@set');

Route::post('/register', 'UserController@register')->name('register');
Route::any('/logout', 'UserController@logout')->name('logout');
Route::put('/user/{userid}', 'UserController@update');

Route::get('/user/activate/{token}', 'UserController@activate')->name('activateUser');
Route::post('/login', 'UserController@login')->name('login');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/category/{category_id}/products', 'AdminController@products');

Route::get('category/{categoryid}/makers','CategoryController@makers');
Route::resource('category','CategoryController');

Route::get('/{maker}/{code}/detail','ProductController@profile');
Route::get('/{maker}/{code}/edit','ProductController@edit');

Route::get('product/search/{query}','ProductController@search');
Route::get('product/list','ProductController@list');
Route::resource('product','ProductController');

// Upload
Route::post('{type}/upload', 'ProductController@upload');


// Settings
Route::get('settings/account', 'UserController@settings');



// Settings
Route::get('email/send/welcome/{userid}', 'UserController@sendActivationEmail');

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home/eshop', 'HomeController@index')->name('home.eshop');

// Users
Route::get('/register', 'UserController@getRegister')->name('getRegister');
Route::post('/register', 'UserController@postRegister')->name('register');
Route::any('/logout', 'UserController@logout')->name('logout');
Route::put('/user/{userid}', 'UserController@update');
Route::delete('/user/{userid}', 'UserController@destroy');
Route::get('/register/success', 'UserController@registerSuccess')->name('registerSuccess');

Route::get('/user/activate/{token}', 'UserController@activate')->name('activateUser');
Route::post('/login', 'UserController@postLogin')->name('postLogin');
Route::get('/login', 'UserController@getLogin')->name('getLogin');

//Cart
Route::get('cart/products','CartController@products');
Route::get('cart/delivery','CartController@delivery');
Route::get('cart/shipping','CartController@shipping');
Route::get('cart/confirm','CartController@confirm');

Route::delete('cart/all','CartController@delete');
Route::post('cart/{productId}','CartController@addItem');
Route::delete('cart/{productid}','CartController@deleteItem');
Route::put('cart/{productid}','CartController@minusItem');
Route::post('cart','CartController@set');


// Categories
Route::post('category/parameter/add','CategoryController@addParameter');
Route::get('category/parameter/{id}/edit','CategoryController@editParameter');
Route::put('category/parameter/{id}','CategoryController@updateParam');

Route::get('category/{categoryid}/makers','CategoryController@makers');
Route::resource('category','CategoryController');


Route::get('/{maker}/{code}/detail','ProductController@profile');
Route::get('/{maker}/{code}/edit','ProductController@edit');

// Products
Route::get('product/search/{query}','ProductController@search');
Route::get('product/{id}/parameters/options','ProductController@paramOptions');
Route::get('product/list','ProductController@list');
Route::post('product/{productid}/change/category/{categoryid}','ProductController@changeCategory');

Route::resource('product','ProductController');

// Upload
Route::post('{type}/upload', 'ProductController@upload');

//Files
Route::resource('file', 'FileController');

// Settings
Route::get('settings/account', 'UserController@settings');

//Orders
Route::get('order/success','OrderController@success');
Route::get('orders/mine','OrderController@myhistory');

Route::resource('order','OrderController');


// Settings
Route::get('email/send/welcome/{userid}', 'UserController@sendActivationEmail');

// Admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function()
{
	Route::get('/products', 'AdminController@manageProducts')->name('admin.manageProducts');
	Route::get('/category/{category_id}/products', 'AdminController@categoryProducts')->name('admin.categoryProducts');
	Route::get('/orders/', 'AdminController@manageOrders')->name('admin.manageOrders');
	Route::get('/users/', 'AdminController@manageUsers')->name('admin.manageUsers');

});

Route::get('cookie', 'AdminController@cookie');

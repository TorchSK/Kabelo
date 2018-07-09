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


// Admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function()
{
	Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');
	Route::get('/products', 'AdminController@manageProducts')->name('admin.products');
	Route::get('/orders/', 'AdminController@manageOrders')->name('admin.orders');
	Route::get('/users/', 'AdminController@manageUsers')->name('admin.users');
	Route::get('/import/', 'AdminController@import')->name('admin.import');
	Route::post('/import/', 'AdminController@postImport')->name('admin.postImport');

	Route::get('/import/json', 'AdminController@importJson')->name('admin.importJson');
	Route::post('/import/json', 'AdminController@postImportJson')->name('admin.postImportJson');

	Route::get('/category/{category}', 'AdminController@categoryProducts')->name('admin.category');
	Route::get('/settings/', 'AdminController@settings')->name('admin.settings');
	Route::post('/delivery', 'AdminController@addDeliveryMethod');
	Route::post('/payment', 'AdminController@addPaymentMethod');

	Route::post('/color', 'AdminController@addColor');

	Route::put('/delivery/{id}', 'AdminController@editDeliveryMethod');
	Route::put('/payment/{id}', 'AdminController@editPaymentMethod');
	Route::get('/order/{id}', 'AdminController@orderDetail')->name('admin.orderDetail');
	Route::get('/user/{id}', 'AdminController@userDetail')->name('admin.userDetail');
	Route::post('/deliverypayment', 'AdminController@addDeliveryPayment');
	Route::delete('/deliverypayment', 'AdminController@removeDeliveryPayment');
	Route::get('/banner/', 'AdminController@addCover')->name('admin.addCover');
	Route::post('/cover/', 'AdminController@storeCover')->name('admin.storeCover');
	Route::post('/cover/upload', 'AdminController@uploadCover')->name('admin.uploadCover');
	Route::put('/cover/setorder', 'AdminController@setCoverOrder')->name('admin.setCoverOrder');
	Route::get('/cover/edit/{id}', 'AdminController@editCover')->name('admin.editcover');
	Route::put('/cover/{id}', 'AdminController@updatecover')->name('admin.updatecover');
	Route::delete('/cover/{id}', 'AdminController@deleteCover')->name('admin.deletecover');
	Route::get('/layout', 'AdminController@layout')->name('admin.layout');
	Route::post('/layout/set', 'AdminController@setLayout')->name('admin.setLayout');
	Route::get('/bulk/', 'ProductController@bulk')->name('admin.bulk');

});

	Route::post('/bulk/', 'ProductController@postBulk')->name('admin.postBulk');

Route::get('/welcome', 'HomeController@welcome')->name('welcome');
Route::post('/login', 'UserController@postLogin')->name('postLogin');
Route::get('/login', 'UserController@getLogin')->name('getLogin');
Route::get('/register', 'UserController@getRegister')->name('getRegister');
Route::post('/register', 'UserController@postRegister')->name('register');
Route::any('/logout', 'UserController@logout')->name('logout');
Route::get('/register/success', 'UserController@registerSuccess')->name('registerSuccess');
Route::get('/user/activate/{token}', 'UserController@activate')->name('activateUser');

Route::group(['middleware' => 'onlyAuth'], function()
{

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home/eshop', 'HomeController@index')->name('home.eshop');

// Users
Route::put('/user/{userid}', 'UserController@update');
Route::delete('/user/{userid}', 'UserController@destroy');


//Cart
Route::get('cart/products','CartController@products');
Route::get('cart/delivery','CartController@delivery');
Route::get('cart/shipping','CartController@shipping');
Route::get('cart/confirm','CartController@confirm');

Route::delete('cart/all','CartController@delete');
Route::post('cart/{productId}','CartController@addItem');
Route::delete('cart/{productid}','CartController@deleteItem');
Route::put('cart/{productid}','CartController@setItem');
Route::post('cart','CartController@set');


// Categories
Route::get('/categories/all','CategoryController@all');

Route::post('category/parameter/add','CategoryController@addParameter');
Route::get('category/parameter/{id}/edit','CategoryController@editParameter');
Route::put('category/parameter/{id}','CategoryController@updateParam');

Route::put('categories/setorder/','CategoryController@setOrder');

Route::get('category/{categoryid}/makers','CategoryController@makers');
Route::resource('category','CategoryController');
Route::get('/category/{category}', 'HomeController@index');
Route::get('/maker/{maker}', 'HomeController@makerProducts')->name('maker.products');

Route::get('/{maker}/{code}/detail','ProductController@profile')->name('product.detail');
Route::get('/{maker}/{code}/edit','ProductController@edit');

Route::post('/category/image/upload','CategoryController@uploadImage');
Route::post('/category/{categoryid}/image/confirmCrop','CategoryController@confirmCrop');

// Products
Route::get('product/search/{query}','ProductController@search');
Route::get('product/{id}/parameters/options','ProductController@paramOptions');
Route::get('product/list','ProductController@list');
Route::post('product/{productid}/change/category/{categoryid}','ProductController@changeCategory');
Route::post('product/{productid}/rating/','ProductController@addRating');

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
});


Route::get('cookie', 'AdminController@cookie');
Route::get('connectors/guide', 'UtilController@connectorsGuide');
Route::get('cookies/info', 'UtilController@cookiesInfo');


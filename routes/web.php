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

	Route::get('/xml/import', 'AdminController@xmlImport')->name('admin.xmlImport');
	Route::get('/translate/', 'AdminController@translate')->name('admin.translate');
	Route::get('/xml/addMoreImages', 'AdminController@addMoreImages')->name('admin.addMoreImages');
	Route::get('/xml/updateXML', 'AdminController@updateXML')->name('admin.updateXML');
	Route::get('/xml/addCategoryPath', 'AdminController@addCategoryPath')->name('admin.addCategoryPath');
	Route::get('/addCategoryFullurl', 'AdminController@addCategoryFullurl')->name('admin.addCategoryFullurl');
	Route::get('/addProductUrl', 'AdminController@addProductUrl')->name('admin.addProductUrl');


	Route::get('/', 'AdminController@dashboardNew')->name('admin.dashboard.new');
	Route::get('/overall', 'AdminController@dashboardOverall')->name('admin.dashboard.overall');


	Route::get('/eshop/categories', 'AdminController@products')->name('admin.eshop.products');
	Route::get('/eshop/products', 'AdminController@categories')->name('admin.eshop.categories');

	Route::get('/orders/', 'AdminController@manageOrders')->name('admin.orders');
	Route::get('/users/', 'AdminController@manageUsers')->name('admin.users');
	Route::get('/import/', 'AdminController@import')->name('admin.import');
	Route::post('/import/', 'AdminController@postImport')->name('admin.postImport');
	Route::get('/files/', 'AdminController@files')->name('admin.files');

	Route::get('/params', 'AdminController@manageParams')->name('admin.params');
	Route::get('/params/category/{categoryid}', 'AdminController@manageCategoryParams')->name('admin.categoryParams');


	Route::get('/import/json', 'AdminController@importJson')->name('admin.importJson');
	Route::post('/import/json', 'AdminController@postImportJson')->name('admin.postImportJson');

	Route::get('/category/{category}', 'AdminController@categoryProducts')->name('admin.category');

	Route::get('/settings/banners', 'AdminController@settingsBanners')->name('admin.settingsBanners');
	Route::get('/settings/eshop', 'AdminController@settingsEshop')->name('admin.settingsEshop');
	Route::get('/settings/invoice', 'AdminController@settingsInvoice')->name('admin.settingsInvoice');
	Route::post('/settings/eshop/save', 'SettingController@bulkUpdate')->name('settings.bulkUpdate');
	Route::get('/settings/delivery', 'AdminController@settingsDelivery')->name('admin.settingsDelivery');

	Route::post('/settings/invoice/save', 'SettingController@bulkUpdate')->name('settings.bulkUpdate');

	Route::post('/delivery', 'AdminController@addDeliveryMethod');
	Route::post('/payment', 'AdminController@addPaymentMethod');

	Route::post('/color', 'AdminController@addColor');

	Route::put('/delivery/{id}', 'AdminController@editDeliveryMethod');
	Route::put('/payment/{id}', 'AdminController@editPaymentMethod');
	Route::get('/order/{id}', 'AdminController@orderDetail')->name('admin.orderDetail');

	Route::get('/user/{id}/detail', 'AdminController@userDetail')->name('admin.userDetail');
	Route::get('/user/{id}/pricing', 'AdminController@userPricing')->name('admin.userPricing');
	Route::get('/user/{id}/orders', 'AdminController@userOrders')->name('admin.userOrders');
	Route::get('/user/{id}/cart', 'AdminController@userCart')->name('admin.userCart');

	Route::post('/deliverypayment', 'AdminController@addDeliveryPayment');
	Route::delete('/deliverypayment', 'AdminController@removeDeliveryPayment');
	Route::put('/deliverypayment', 'AdminController@changeDeliveryPayment');

	Route::get('/banner/', 'AdminController@addCover')->name('admin.addCover');
	Route::post('/cover/', 'AdminController@storeCover')->name('admin.storeCover');
	Route::post('/cover/upload', 'AdminController@uploadCover')->name('admin.uploadCover');
	
	Route::post('/banner/upload', 'AdminController@uploadAndStoreBanner')->name('admin.uploadAndStoreBanner');

	Route::put('/cover/setorder', 'AdminController@setCoverOrder')->name('admin.setCoverOrder');
	Route::get('/cover/edit/{id}', 'AdminController@editCover')->name('admin.editcover');
	Route::put('/cover/{id}', 'AdminController@updatecover')->name('admin.updatecover');
	Route::delete('/cover/{id}', 'AdminController@deleteCover')->name('admin.deletecover');
	Route::get('/layout', 'AdminController@layout')->name('admin.layout');
	Route::post('/layout/set', 'AdminController@setLayout')->name('admin.setLayout');
	Route::get('/bulk/', 'ProductController@bulk')->name('admin.bulk');

});

Route::post('/bulk/', 'ProductController@postBulk')->name('admin.postBulk');

Route::get('/stock/', 'ProductController@setStock')->name('setStock');

Route::get('/welcome', 'HomeController@welcome')->name('welcome');
Route::post('/login', 'UserController@postLogin')->name('postLogin');
Route::get('/login', 'UserController@getLogin')->name('login');
Route::get('/register', 'UserController@getRegister')->name('getRegister');
Route::post('/register', 'UserController@postRegister')->name('register');
Route::any('/logout', 'UserController@logout')->name('logout');
Route::get('/register/success', 'UserController@registerSuccess')->name('registerSuccess');
Route::get('/user/activate/{token}', 'UserController@activate')->name('activateUser');


Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');;
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.request');

Route::group([], function()
{

Route::get('/', 'HomeController@index')->name('home.index');

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
Route::post('cart/{cartid}/{productId}','CartController@addItem');
Route::delete('cart/{cartid}/{productid}','CartController@deleteItem');
Route::put('cart/{cartid}/{productid}','CartController@setItem');
Route::post('cart','CartController@set');

// Products
Route::get('product/{id}/parameters/options','ProductController@paramOptions');
Route::get('product/list','ProductController@list');
Route::get('makerproduct/list','ProductController@makerlist');

Route::post('product/{productid}/change/category/{categoryid}','ProductController@changeCategory');
Route::post('product/{productid}/rating/','ProductController@addRating');
Route::resource('product','ProductController');
Config::set('database.default', 'dedra');

Route::get('p/{url}', 'ProductController@profile')->name('product.detail');

// Categories
Route::get('/categories/all','CategoryController@all');

Route::get('/filterbar', 'CategoryController@filterbar');
Route::put('/category/set/{id}','CategoryController@set');


Route::post('category/parameter/add','CategoryController@addParameter');
Route::get('category/parameter/{id}/edit','CategoryController@editParameter');
Route::delete('category/parameter/{id}','CategoryController@deleteParameter');
Route::put('category/parameter/{id}','CategoryController@updateParam');

Route::put('categories/setorder/','CategoryController@setOrder');

Route::get('category/{categoryid}/makers','CategoryController@makers');
Route::resource('category','CategoryController');

Route::get('/{path}', 'CategoryController@products')->where('path','(.*)')->name('category.products');

Route::get('/maker/{maker}', 'HomeController@makerProducts')->name('maker.products');

Route::get('/{maker}/{code}/edit','ProductController@edit');

Route::post('/category/image/upload','CategoryController@uploadImage');
Route::post('/category/{categoryid}/image/confirmCrop','CategoryController@confirmCrop');



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


//Parameter
Route::resource('param','ParamController');


// Settings
Route::get('email/send/welcome/{userid}', 'UserController@sendActivationEmail');
});


Route::get('katalog/{id}', 'UtilController@catalogue');


Route::get('cookie', 'UtilController@cookie');
Route::get('connectors/guide', 'UtilController@connectorsGuide');

Route::get('kontakt', 'UtilController@contactPage');
Route::get('obchodne-podmienky', 'UtilController@termsPage');
Route::get('obchodne-podmienky/edit', 'UtilController@termsPage');
Route::get('gdpr', 'UtilController@gdprPage');
Route::get('gdpr/edit', 'UtilController@gdprPage');

Route::get('cookies/info', 'UtilController@cookiesInfo');
Route::get('email/order', 'UtilController@sendOrderEmail');
Route::post('set/config', 'UtilController@setConfig');

Route::post('text', 'UtilController@setText');

Route::post('cookies', 'UtilController@setCookie');

Route::get('search/{query}', 'UtilController@search');

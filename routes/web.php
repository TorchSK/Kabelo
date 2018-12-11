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
	Route::get('/copper/loadProducts', 'AdminController@copperLoadProducts');
	Route::get('/copper/loadCategories', 'AdminController@copperLoadCategories');
	Route::get('/copper/addCategoryParent', 'AdminController@copperAddCategoryParent');
	Route::get('/copper/addPrices', 'AdminController@copperAddPrices');
	Route::get('/copper/attachCategories', 'AdminController@copperAttachCategories');
	Route::get('/copper/init', 'AdminController@copperInit');
	Route::get('/copper/attachFiles', 'AdminController@copperAttachFiles');
	Route::get('/copper/addDesc', 'AdminController@copperAddDesc');

	Route::get('/xml/import', 'AdminController@xmlImport')->name('admin.xmlImport');
	Route::get('/translate/', 'AdminController@translate')->name('admin.translate');
	Route::get('/xml/addMoreImages', 'AdminController@addMoreImages')->name('admin.addMoreImages');
	Route::get('/xml/postXmlUpdate', 'AdminController@postXmlUpdate')->name('admin.postXmlUpdate');
	Route::get('/addCategoryPath', 'AdminController@addCategoryPath')->name('admin.addCategoryPath');
	Route::get('/addCategoryFullurl', 'AdminController@addCategoryFullurl')->name('admin.addCategoryFullurl');
	Route::get('/addProductUrl', 'AdminController@addProductUrl')->name('admin.addProductUrl');


	Route::get('/dashboard', 'AdminController@dashboardNew')->name('admin.dashboard.new');
	Route::get('/dashboard/overall', 'AdminController@dashboardOverall')->name('admin.dashboard.overall');
	
	Route::put('/eshop/postXmlUpdate', 'AdminController@postXmlUpdate')->name('admin.postXmlUpdate');
	Route::get('/eshop/xmlupdate', 'AdminController@xmlUpdate')->name('admin.eshop.xmlupdate');
	Route::get('/eshop/products', 'AdminController@products')->name('admin.eshop.products');
	Route::get('/eshop/categories', 'AdminController@categories')->name('admin.eshop.categories');
	Route::get('/eshop/category/{category}', 'AdminController@category')->name('admin.eshop.category');
	Route::get('/eshop/new', 'AdminController@new')->name('admin.eshop.new');
	Route::get('/eshop/sale', 'AdminController@sale')->name('admin.eshop.sale');
	Route::get('/eshop/inactive', 'AdminController@inactive')->name('admin.eshop.inactive');
	Route::get('/eshop/stickers', 'AdminController@eshopStickers')->name('admin.eshop.stickers');
	Route::get('/eshop/product/{product}', 'AdminController@productEdit')->name('admin.eshop.product.edit');


	Route::get('/orders/', 'AdminController@manageOrders')->name('admin.orders');
	Route::get('/import/', 'AdminController@import')->name('admin.import');
	Route::post('/import/', 'AdminController@postImport')->name('admin.postImport');

	Route::get('/files/', 'AdminController@files')->name('admin.files.files');
	Route::get('/catalogues/', 'AdminController@catalogues')->name('admin.files.catalogues');
	Route::get('/stickers/', 'AdminController@stickers')->name('admin.files.stickers');

	Route::get('/params', 'AdminController@params')->name('admin.params.index');

	Route::get('/users/', 'AdminController@users')->name('admin.users.index');

	Route::get('/orders/', 'AdminController@orders')->name('admin.orders.index');

	Route::get('/params/category/{categoryid}', 'AdminController@manageCategoryParams')->name('admin.categoryParams');

	Route::get('/layout', 'AdminController@layout')->name('admin.layout');

	Route::get('/import/json', 'AdminController@importJson')->name('admin.importJson');
	Route::post('/import/json', 'AdminController@postImportJson')->name('admin.postImportJson');

	Route::get('/settings/eshop', 'AdminController@eshop')->name('admin.settings.eshop');
	Route::get('/settings/invoice', 'AdminController@invoice')->name('admin.settings.invoice');
	Route::get('/settings/delivery', 'AdminController@delivery')->name('admin.settings.delivery');
	Route::post('/settings/eshop/save', 'SettingController@bulkUpdate')->name('settings.bulkUpdate');
	Route::post('/settings/invoice/save', 'SettingController@bulkUpdate')->name('settings.bulkUpdate');
	Route::get('/settings/site', 'AdminController@site')->name('admin.settings.site');

	Route::post('/delivery', 'AdminController@addDeliveryMethod');
	Route::post('/payment', 'AdminController@addPaymentMethod');

	Route::post('/color', 'AdminController@addColor');

	Route::put('/delivery/{id}', 'AdminController@editDeliveryMethod');
	Route::delete('/delivery/{id}', 'AdminController@deleteDeliveryMethod');
	Route::delete('/payment/{id}', 'AdminController@deletePaymentMethod');

	Route::put('/payment/{id}', 'AdminController@editPaymentMethod');
	Route::get('/order/{id}', 'AdminController@orderDetail')->name('admin.orderDetail');

	Route::get('/user/{id}/detail', 'AdminController@userDetail')->name('admin.userDetail');
	Route::get('/user/{id}/pricing', 'AdminController@userPricing')->name('admin.userPricing');
	Route::get('/user/{id}/orders', 'AdminController@userOrders')->name('admin.userOrders');
	Route::get('/user/{id}/cart', 'AdminController@userCart')->name('admin.userCart');

	Route::post('/deliverypayment', 'AdminController@addDeliveryPayment');
	Route::delete('/deliverypayment', 'AdminController@removeDeliveryPayment');
	Route::put('/deliverypayment', 'AdminController@changeDeliveryPayment');

	Route::get('/banners/', 'AdminController@banners')->name('admin.banners');

	Route::get('/banner/', 'AdminController@makeCover')->name('admin.makeCover');
	Route::post('/cover/', 'AdminController@storeCover')->name('admin.storeCover');
	Route::post('/cover/upload', 'AdminController@uploadCover')->name('admin.uploadCover');
	
	Route::post('/banner/upload', 'AdminController@uploadAndStoreBanner')->name('admin.uploadAndStoreBanner');

	Route::put('/cover/setorder', 'AdminController@setCoverOrder')->name('admin.setCoverOrder');
	Route::get('/cover/edit/{id}', 'AdminController@editCover')->name('admin.editcover');
	Route::put('/cover/{id}', 'AdminController@updatecover')->name('admin.updatecover');
	Route::delete('/cover/{id}', 'AdminController@deleteCover')->name('admin.deletecover');





	Route::get('/layout/templates', 'AdminController@layoutTemplates')->name('admin.layout.templates');
	Route::get('/layout/pages', 'AdminController@layout')->name('admin.layout.pages');

	Route::get('/pages/list', 'AdminController@pages')->name('admin.pages.list');
	Route::get('/pages/texts', 'AdminController@texts')->name('admin.pages.texts');

	Route::post('/layout/set', 'AdminController@setLayout')->name('admin.setLayout');
	Route::get('/bulk/', 'ProductController@bulk')->name('admin.eshop.bulk');

	Route::get('p/edit/{url}', 'ProductController@edit')->name('admin.product.edit');
	
	Route::put('/setting/', 'SettingController@apiUpdate')->name('admin.setting.apiUpdate');
	
	Route::get('/page/{url}', 'AdminController@pageEdit')->name('admin.pages.pageEdit');
	Route::get('/text/{url}', 'AdminController@textEdit')->name('admin.pages.textEdit');
	
	Route::get('/sticker/{url}', 'AdminController@stickerEdit')->name('admin.files.stickerEdit');
	Route::post('/stickers/attach/', 'AdminController@stickerAttach')->name('admin.files.stickerAttach');


	Route::put('/page/setting/', 'SettingController@pageUpdate')->name('admin.setting.pageUpdate');


});


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

// Banners
Route::resource('banner','BannerController');

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


Route::get('/m/{maker}', 'HomeController@makerProducts')->name('maker.products');

Route::get('/{maker}/{code}/edit','ProductController@edit');

Route::post('/category/image/upload','CategoryController@uploadImage');
Route::post('/category/{categoryid}/image/confirmCrop','CategoryController@confirmCrop');


// Pages
Route::put('/page/set/{id}','PageController@set');
Route::put('pages/setorder/','PageController@setOrder');
Route::post('/page/{pageid}/attach/{textid}', 'PageController@attachText')->name('admin.pages.attachText');
Route::post('/page/{pageid}/detach/{textid}', 'PageController@detachText')->name('admin.pages.detachText');

Route::resource('page','PageController');

// Texts
Route::resource('text','TextController');



// Upload
Route::post('{type}/upload', 'ProductController@upload');

//Files
Route::resource('file', 'FileController');
Route::post('catalogue/changeImage', 'FileController@changeCatalogueImage');

//Stickers
Route::resource('sticker', 'StickerController');

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


Route::get('cookies/info', 'UtilController@cookiesInfo');
Route::get('email/order', 'UtilController@sendOrderEmail');
Route::post('set/config', 'UtilController@setConfig');

Route::post('cookies', 'UtilController@setCookie');

Route::get('search/{query}', 'UtilController@search');

Route::get('/{url}', 'SlugController@show')->name('slug');


Route::get('/{path}', 'CategoryController@products')->where('path','(.*)')->name('category.products');

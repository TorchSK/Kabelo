<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('orders/countbydays/{daysago}', 'OrderController@countByDays');
Route::get('users/countbydays/{daysago}', 'UserController@countByDays');
Route::get('products/search', 'ProductController@inputSearch');
Route::get('products/all', 'ProductController@all');

Route::get('categories/search', 'CategoryController@inputSearch');

Route::put('product/{id}', 'ProductController@apiUpdate');

Route::get('view/pricelevel', 'ProductController@viewPriceLevel');

Route::get('search/{query}', 'UtilController@searchAll');

Route::post('/bulk/', 'ProductController@postBulk')->name('admin.postBulk');

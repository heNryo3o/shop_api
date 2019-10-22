<?php

/**
 * 小程序路由
 */

Route::post('/user/token','UserController@token');
Route::post('/user/edit','UserController@edit');

Route::get('/category/index','CategoryController@index');
Route::get('/category/sub','CategoryController@sub');

Route::get('/system/banners','SystemController@banners');

Route::get('/product/index','ProductController@index');
Route::get('/product/dapai','ProductController@dapai');
Route::get('/product/info','ProductController@info');
Route::get('/product/evalue-list','ProductController@evalueList');
Route::get('/product/cart-list','ProductController@cartList');

Route::post('/product/add-cart','ProductController@addCart');
Route::post('/product/collect','ProductController@collect');
Route::post('/product/del-cart','ProductController@delCart');
Route::post('/product/cart-change-number','ProductController@cartChangeNumber');

Route::get('/store/info','StoreController@info');
Route::get('/store/index','StoreController@index');
Route::get('/store/product-list','StoreController@productList');

Route::post('/order/cart-create','OrderController@cartCreate');

Route::get('/order/info','OrderController@info');
Route::get('/order/index','OrderController@index');
Route::get('/order/submit','OrderController@submit');

Route::post('/order/generate-pay','OrderController@generatePay');
Route::post('/order/deposit-pay','OrderController@depositPay');

Route::get('/location/default','LocationController@default');
Route::get('/location/index','LocationController@index');
Route::post('/location/create','LocationController@create');
Route::post('/location/edit','LocationController@edit');
Route::post('/location/delete','LocationController@delete');

Route::post('/store/collect','StoreController@collect');

Route::get('/system/chat-log','SystemController@chatLog');



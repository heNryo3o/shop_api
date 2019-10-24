<?php

/**
 * 小程序路由
 */

Route::post('/user/token','UserController@token');
Route::post('/user/edit','UserController@edit');
Route::get('/user/info','UserController@info');

Route::get('/category/index','CategoryController@index');
Route::get('/category/sub','CategoryController@sub');

Route::get('/system/banners','SystemController@banners');

Route::get('/product/index','ProductController@index');
Route::get('/product/collect-index','ProductController@collectIndex');
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
Route::get('/store/collect-index','StoreController@collectIndex');
Route::get('/store/product-list','StoreController@productList');

Route::post('/order/cart-create','OrderController@cartCreate');
Route::post('/order/buy-create','OrderController@buyCreate');

Route::get('/order/info','OrderController@info');
Route::get('/order/index','OrderController@index');
Route::get('/order/submit','OrderController@submit');

Route::post('/order/generate-pay','OrderController@generatePay');
Route::post('/order/deposit-pay','OrderController@depositPay');

Route::post('/order/evalue','OrderController@evalue');

Route::post('/order/confirm-recieve','OrderController@confirmRecieve');

Route::post('/order/deposit','OrderController@deposit');

Route::get('/location/default','LocationController@default');
Route::get('/location/index','LocationController@index');
Route::post('/location/create','LocationController@create');
Route::post('/location/edit','LocationController@edit');
Route::post('/location/delete','LocationController@delete');

Route::post('/order/submit-refund','OrderController@submitRefund');

Route::post('/store/collect','StoreController@collect');

Route::get('/system/chat-log','SystemController@chatLog');

Route::post('/system/notify','SystemController@notify');

Route::post('/system/upload','SystemController@upload');

Route::get('/system/deposit-setting','SystemController@depositSetting');

Route::get('/system/haibao','SystemController@haibao');

Route::post('/user/bind-push','UserController@bindPush');
Route::post('/user/bind-parent','UserController@bindParent');
Route::post('/user/bind-mobile','UserController@bindMobile');

Route::get('/order/check-order','OrderController@checkOrder');   //线下核销页
Route::post('/order/confirm-check','OrderController@confirmCheck');   //线下核销页

Route::post('/user/j-register','UserController@jRegister');   //线下核销页

Route::get('/user/remain-log','UserController@remainLog');   //线下核销页





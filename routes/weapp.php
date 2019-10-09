<?php

/**
 * 小程序路由
 */

Route::post('/user/token','UserController@token');
Route::post('/user/edit','UserController@edit');

Route::get('/category/index','CategoryController@index');

Route::get('/system/banners','SystemController@banners');

Route::get('/product/index','ProductController@index');
Route::get('/product/info','ProductController@info');
Route::get('/product/evalue-list','ProductController@evalueList');

Route::post('/product/collect','ProductController@collect');

Route::get('/store/info','StoreController@info');
Route::get('/store/product-list','StoreController@productList');

Route::post('/store/collect','StoreController@collect');



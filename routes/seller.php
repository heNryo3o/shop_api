<?php

/**
 * 商家后台路由
 */

// 管理员登录登出,获取登录者信息

Route::get('/login/info','LoginController@info');

Route::post('/login/login','LoginController@login');
Route::post('/login/logout','LoginController@logout');

Route::get('/category/options','CategoryController@options');
Route::get('/category/sub-options','CategoryController@subOptions');

Route::post('/system/upload','SystemController@upload');

// 店铺模块

Route::get('/store/info','StoreController@info');

Route::post('/store/create','StoreController@create');
Route::post('/store/edit','StoreController@edit');
Route::post('/store/change-status','StoreController@changeStatus');

Route::get('/product/index','ProductController@index');

Route::post('/product/create','ProductController@create');
Route::post('/product/edit','ProductController@edit');
Route::post('/product/change-status','ProductController@changeStatus');

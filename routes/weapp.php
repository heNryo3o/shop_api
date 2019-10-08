<?php

/**
 * 小程序路由
 */

Route::post('/user/token','UserController@token');
Route::post('/user/edit','UserController@edit');

Route::get('/category/index','CategoryController@index');

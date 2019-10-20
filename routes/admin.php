<?php

/**
 * 管理后台路由
 */

// 管理员登录登出,获取登录者信息

Route::get('/login/info','LoginController@info');

Route::post('/login/login','LoginController@login');
Route::post('/login/logout','LoginController@logout');

// 管理员模块

Route::get('/admin/index','AdminController@index');
Route::get('/admin/department-options','AdminController@departmentOptions');
Route::get('/admin/admin-options','AdminController@adminOptions');

Route::post('/admin/create','AdminController@create');
Route::post('/admin/edit','AdminController@edit');
Route::post('/admin/change-status','AdminController@changeStatus');

// 角色模块

Route::get('/role/index','RoleController@index');
Route::get('/role/role-options', 'RoleController@roleOptions');

Route::post('/role/create','RoleController@create');
Route::post('/role/edit','RoleController@edit');
Route::post('/role/destroy','RoleController@destroy');
Route::post('/role/change-status','RoleController@changeStatus');

// 权限模块

Route::get('/permission/index','PermissionController@index');
Route::get('permission/cal-permissions','PermissionController@calPermissions');
Route::get('permission/permission-options','PermissionController@permissionOptions');
Route::get('permission/parent-options','PermissionController@parentOptions');


Route::post('/permission/create','PermissionController@create');
Route::post('/permission/edit','PermissionController@edit');
Route::post('/permission/destroy','PermissionController@destroy');
Route::post('/permission/change-status','PermissionController@changeStatus');

// 地区模块

Route::get('/area/index','AreaController@index');

Route::post('/area/create','AreaController@create');
Route::post('/area/edit','AreaController@edit');
Route::post('/area/destroy','AreaController@destroy');
Route::post('/area/change-status','AreaController@changeStatus');

// 分类模块

Route::get('/category/index','CategoryController@index');
Route::get('/category/sub-options','CategoryController@subOptions');
Route::get('/category/parent-options','CategoryController@parentOptions');

Route::post('/category/create','CategoryController@create');
Route::post('/category/edit','CategoryController@edit');
Route::post('/category/destroy','CategoryController@destroy');
Route::post('/category/change-status','CategoryController@changeStatus');

// 上传记录模块

Route::get('/upload/index','UploadController@index');

Route::post('/upload/create','UploadController@create');
Route::post('/upload/edit','UploadController@edit');
Route::post('/upload/destroy','UploadController@destroy');
Route::post('/upload/change-status','UploadController@changeStatus');

// 用户模块

Route::get('/user/index','UserController@index');
Route::get('/user/logs','UserController@logs');

Route::post('/user/create','UserController@create');
Route::post('/user/edit','UserController@edit');
Route::post('/user/destroy','UserController@destroy');
Route::post('/user/change-status','UserController@changeStatus');

Route::post('/system/upload','SystemController@upload');
Route::post('/system/save-banner','SystemController@saveBanner');

Route::get('/system/info','SystemController@info');

// 店铺模块

Route::get('/store/index','StoreController@index');
Route::get('/store/info','StoreController@info');

Route::post('/store/create','StoreController@create');
Route::post('/store/edit','StoreController@edit');
Route::post('/store/destroy','StoreController@destroy');
Route::post('/store/change-status','StoreController@changeStatus');

Route::get('/product/index','ProductController@index');
Route::get('/product/info','ProductController@info');

Route::post('/product/create','ProductController@create');
Route::post('/product/edit','ProductController@edit');
Route::post('/product/destroy','ProductController@destroy');
Route::post('/product/change-status','ProductController@changeStatus');
Route::post('/product/set-dapai','ProductController@setDapai');


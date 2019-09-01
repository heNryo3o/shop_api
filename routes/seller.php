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

// 名片模块

Route::get('/card/index','CardController@index');

Route::post('/card/create','CardController@create');
Route::post('/card/edit','CardController@edit');
Route::post('/card/destroy','CardController@destroy');
Route::post('/card/change-status','CardController@changeStatus');

// 案例模块

Route::get('/cases/index','CasesController@index');

Route::post('/cases/create','CasesController@create');
Route::post('/cases/edit','CasesController@edit');
Route::post('/cases/destroy','CasesController@destroy');
Route::post('/cases/change-status','CasesController@changeStatus');

// 分类模块

Route::get('/category/index','CategoryController@index');
Route::get('/category/parent-options','CategoryController@parentOptions');

Route::post('/category/create','CategoryController@create');
Route::post('/category/edit','CategoryController@edit');
Route::post('/category/destroy','CategoryController@destroy');
Route::post('/category/change-status','CategoryController@changeStatus');

// 企业认证模块

Route::get('/company-validate/index','CompanyValidateController@index');

Route::post('/company-validate/create','CompanyValidateController@create');
Route::post('/company-validate/edit','CompanyValidateController@edit');
Route::post('/company-validate/destroy','CompanyValidateController@destroy');
Route::post('/company-validate/change-status','CompanyValidateController@changeStatus');

// 个人认证模块

Route::get('/person-validate/index','PersonValidateController@index');

Route::post('/person-validate/create','PersonValidateController@create');
Route::post('/person-validate/edit','PersonValidateController@edit');
Route::post('/person-validate/destroy','PersonValidateController@destroy');
Route::post('/person-validate/change-status','PersonValidateController@changeStatus');

// 派单模块

Route::get('/dispatch/index','DispatchController@index');

Route::post('/dispatch/create','DispatchController@create');
Route::post('/dispatch/edit','DispatchController@edit');
Route::post('/dispatch/destroy','DispatchController@destroy');
Route::post('/dispatch/change-status','DispatchController@changeStatus');

// 新闻模块

Route::get('/news/index','NewsController@index');

Route::post('/news/create','NewsController@create');
Route::post('/news/edit','NewsController@edit');
Route::post('/news/destroy','NewsController@destroy');
Route::post('/news/change-status','NewsController@changeStatus');

// 线下对接模块

Route::get('/offline/index','OfflineController@index');

Route::post('/offline/create','OfflineController@create');
Route::post('/offline/edit','OfflineController@edit');
Route::post('/offline/destroy','OfflineController@destroy');
Route::post('/offline/change-status','OfflineController@changeStatus');

// 推送模块

Route::get('/push/index','PushController@index');
Route::get('/push/module-options','PushController@moduleOptions');
Route::get('/push/logs','PushController@logs');
Route::get('/push/type-options','PushController@typeOptions');

Route::post('/push/create','PushController@create');
Route::post('/push/edit','PushController@edit');
Route::post('/push/destroy','PushController@destroy');
Route::post('/push/change-status','PushController@changeStatus');

// 店铺服务模块

Route::get('/product/index','ProductController@index');

Route::post('/product/create','ProductController@create');
Route::post('/product/edit','ProductController@edit');
Route::post('/product/destroy','ProductController@destroy');
Route::post('/product/change-status','ProductController@changeStatus');

// 店铺模块

Route::get('/store/index','StoreController@index');

Route::post('/store/create','StoreController@create');
Route::post('/store/edit','StoreController@edit');
Route::post('/store/destroy','StoreController@destroy');
Route::post('/store/change-status','StoreController@changeStatus');

// 参与任务模块

Route::get('/task-join/index','TaskJoinController@index');

Route::post('/task-join/create','TaskJoinController@create');
Route::post('/task-join/edit','TaskJoinController@edit');
Route::post('/task-join/destroy','TaskJoinController@destroy');
Route::post('/task-join/change-status','TaskJoinController@changeStatus');

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



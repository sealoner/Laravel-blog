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



Route::get('/','home\IndexController@index');

Route::group(['prefix'=>'blogadmin','namespace'=>'blogadmin'], function (){
    Route::any('/','LoginController@login');
    Route::any('login','LoginController@login');
    Route::get('code','LoginController@code');
    Route::get('getcode','LoginController@getcode');
    Route::any('quit','LoginController@quit');
    Route::get('register','RegisterController@register');
});

//设置前台控制器组
Route::group(['prefix'=>'home','namespace'=>'home'],function(){
    Route::any('/index','IndexController@index');
    Route::any('/cat/{cate_id}','IndexController@cat');
    Route::any('article/{art_id}','IndexController@article');
});


//设置后台权限控制器
Route::group(['prefix'=>'blogadmin','namespace'=>'blogadmin','middleware'=>'admin.login'], function() {
    Route::any('index','IndexController@index');
    Route::any('info','IndexController@info');
    Route::any('pass','IndexController@pass');
    
    Route::post('category/order','CategoryController@order');
    Route::resource('category','CategoryController');
//    设置文章路由
    Route::resource('article','ArticleController');
    //设置图片上传路由
    Route::any('upload','CommonController@upload');

    //友情链接资源路由
    Route::resource('links','LinksController');
    Route::post('links/order','LinksController@order');

    //导航资源路由
    Route::resource('navs','NavsController');
    Route::post('navs/order','NavsController@order');

    //网站配置路由
    Route::resource('config','ConfigController');
    Route::post('config/order','ConfigController@order');
    Route::post('config/changecontent','ConfigController@changecontent');
    Route::get('config/putfile','ConfigController@putFile');
});

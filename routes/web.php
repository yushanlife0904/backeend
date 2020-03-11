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

Route::get('/', 'FrontController@index');

Route::get('/news','FrontController@news');
Route::get('/news_detail/{id}','FrontController@news_detail');

Route::get('/products','FrontController@products');
Route::get('/products_detail/{id}','FrontController@products_detail');

Route::get('/contact','FrontController@contact');

Auth::routes();


Route::group (['middleware' => ['auth'],'prefix' => '/home'],function(){

     //首頁
     Route::get('/', 'HomeController@index');

     //最新消息
     Route::get('news', 'NewsController@index');

     Route::get('news/create', 'NewsController@create');
     Route::post('news/store', 'NewsController@store');

     Route::get('news/edit/{id}', 'NewsController@edit');
     Route::post('news/update/{id}', 'NewsController@update');

     Route::post('news/delete/{id}', 'NewsController@delete');
     Route::post('ajax_delete_news_imgs', 'NewsController@ajax_delete_news_imgs');

     Route::post('ajax_upload_img', 'UploadImgController@ajax_upload_img');
     Route::post('ajax_delete_img', 'UploadImgController@ajax_delete_img');


     //產品管理
     Route::get('products', 'ProductsController@index');
     Route::get('products/create', 'ProductsController@create');
     Route::post('products/store', 'ProductsController@store');

     Route::get('products/edit/{id}', 'ProductsController@edit');
     Route::post('products/update/{id}', 'ProductsController@update');

     Route::post('products/delete/{id}', 'ProductsController@delete');

     //產品類別管理
     Route::get('productType', 'ProductTypeController@index');
     Route::get('productType/create', 'ProductTypeController@create');
     Route::post('productType/store', 'ProductTypeController@store');

     Route::get('productType/edit/{id}', 'ProductTypeController@edit');
     Route::post('productType/update/{id}', 'ProductTypeController@update');

     Route::post('productType/delete/{id}', 'ProductTypeController@delete');

     //聯絡我們


});








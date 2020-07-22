<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::prefix('login')->group(function () {
    Route::get("/reg","Index\LonginController@reg");//前台注册
    Route::post("/regdo","Index\LonginController@regdo");//执行注册
    Route::get("/login","Index\LonginController@login");//前台登录
    Route::get("/login","Index\LonginController@login");//前台登录
    Route::post("/logindo","Index\LonginController@logindo");//执行登录

});
Route::any("/","Index\IndexController@index")->middleware('login');//前台首页
Route::any("/link","Index\IndexController@link")->middleware('login');//商品列表
Route::any("/details/{id}","Index\IndexController@details")->middleware('login');//商品详情




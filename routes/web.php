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

Route::any("/","Index\IndexController@index");//前台首页
Route::any("/link","Index\IndexController@link");//商品列表
Route::any("/details/{id}","Index\IndexController@details");//商品详情



Route::post("/addCart","Index\CartController@addCart");//加入购物车
Route::get("/cart","Index\CartController@cartList");//购物车列表
Route::post("/changeNumber","Index\CartController@changeNumber");//更改购买数据
Route::post("/getTotal","Index\CartController@getTotal");//更改购买数据
Route::post("/del","Index\CartController@del");//删除



Route::prefix('login')->group(function () {
    Route::get("/reg","Index\LonginController@reg");//前台注册
    Route::post("/regdo","Index\LonginController@regdo");//执行注册
    Route::get("/login","Index\LonginController@login");//前台登录
    Route::get("/login","Index\LonginController@login");//前台登录
    Route::post("/logindo","Index\LonginController@logindo");//执行登录
    Route::get("/quit","Index\LonginController@quit");//销毁
});



Route::prefix('wish')->group(function () {
    Route::get("wish","Index\WishController@wish");//收藏
    Route::get("wishDo","Index\WishController@wishDo");//点击收藏按钮
    Route::get("wishDel","Index\WishController@wishDel");//取消收藏
});





<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LonginController extends Controller
{
    //注册
    public function reg(){
        return view("index.login.reg");
    }
    //登录
    public function login(){
        return view("index.login.login");
    }
}

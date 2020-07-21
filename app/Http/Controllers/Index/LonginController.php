<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\IndexUser;
class LonginController extends Controller
{
    //注册
    public function reg(){
        return view("index.login.reg");
    }
    //执行注册
    public function regdo(Request $request){
        $post=request()->except('_token');
        $reg='/^1[3578]\d{9}$/';
        $pwd_reg="/^\w{6,16}$/";
        if(preg_match($reg,$post['tel'])<1){
            header('Refresh:2,url=/login/reg');
            echo "手机号有误";exit;
        }
        $user=IndexUser::where('name',$post['name'])->first();
        if (!empty($user)){
            header('Refresh:2,url=/login/reg');
            echo "名称已存在请重新输入";exit;
        }
        $email=IndexUser::where('email',$post['email'])->first();
        if (!empty($email)){
            header('Refresh:2,url=/login/reg');
            echo "邮箱已存在请重新输入";exit;
        }
        $tel=IndexUser::where('tel',$post['tel'])->first();
        if (!empty($tel)){
            header('Refresh:2,url=/login/reg');
            echo "手机号已注册请重新输入";exit;
        }
        if(preg_match($pwd_reg,$post['password'])){
            header('Refresh:2,url=/login/reg');
            echo "密码数字字母下划线6-16位";exit;
        }
        if ($post['password']!=$post['passwords']){
            header('Refresh:2,url=/login/reg');
            echo "两次密码不一致请重新输入";exit;
        }else{
            $post['password']=password_hash($post['password'],PASSWORD_BCRYPT);
            $post['addtime']=time();
            $res=IndexUser::create($post);
            if ($res){
                header('Refresh:2,url=/login/login');
                echo "注册成功";exit;
            }
        }

    }
    //登录
    public function login(){
        return view("index.login.login");
    }
    //执行登录
    public function logindo(Request $request){
        $name=$request->input('name');
        $password=$request->input('password');
        $user=IndexUser::where('name',$name)->first();
        if (empty($user)){
            header('Refresh:2,url=/login/login');
            echo "用户名密码错误请重新登录";exit;
        }
        if(password_verify($password,$user['password'])){
            header('Refresh:2,url=/create');
            session(['user'=>$user]);
        }else{
            echo "登录成功";
            header('Refresh:2,url=/login/login');
            echo "用户名密码错误请重新登录";exit;
        }
    }

}

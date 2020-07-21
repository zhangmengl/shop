<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cart;

class CartController extends Controller
{
    //加入购物车
    public function addCart(Request $request){
        //接收商品id
        $goods_id=$request->input("goods_id");
        //接收购买数量
        $buy_number=$request->input("buy_number");
        判断用户是否登录  检测是否有，登陆时的存储session信息
        if($this->checkLogin()){
            //加入购物车  数据库
            $res=$this->addCartDb($goods_id,$buy_number);
        }else{
            //加入购物车  cookie
            $res=$this->addCartCookie($goods_id,$buy_number);
        }
        dump($res);
    }
    public function addCartDb($goods_id,$buy_number){
        //接收用户id
        $user_id=$this->getUserId();
        //实例化对象  购物车
        $cart=new CartModel();
        //where条件
        $where=[
            ['goods_id','=',$goods_id],
            ['user_id','=',$user_id],
            ['cart_del','=',1]
        ];
        //在购物车表  查一条数据
        $cartInfo=$cart->where($where)->find();
        //dump($cartInfo);exit;
        //查询库存 
        $goods=new GoodsModel();
        $goods_num=$goods->where('goods_id',$goods_id)->value('goods_num');
        //判断查询购物车的这条数据存在时
        if(!empty($cartInfo)){
            $num=$cartInfo['buy_number']+$buy_number;
            //检测库存
            //如果购物车里的数量+点击的数量>库存
            if($num>$goods_num){
                //那么点击的数量=库存
                $num=$goods_num;
            }
            //购买数量累加
            $res=$cart->where($where)->update(['buy_number'=>$num,'add_time'=>time()]);
            if($res){
                successly("");
            }else{
                fail('加入购物车失败');
            }
        }else{
            //检测库存
            if($buy_number>$goods_num){
                $buy_number=$goods_num;
            }
            //添加数据
            //把商品id、购买数量、加入时间、用户id存入数据库
            $info=['goods_id'=>$goods_id,'buy_number'=>$buy_number,'add_time'=>time(),'user_id'=>$user_id];
            $res=$cart->save($info);
            if($res){
                successly("");
            }else{
                fail('加入购物车失败');
            }
        }
    }
    //加入购物车  cookie
    public function addCartCookie($goods_id,$buy_number){
        //取出cookie
        $cartInfo=cookie('cartInfo');
        if(empty($cartInfo)){
            $cartInfo=[];
        }
        //查询库存
        //实例化对象  商品
        $goods=new GoodsModel();
        $goods_num=$goods->where('goods_id',$goods_id)->value('goods_num');
        if(array_key_exists($goods_id,$cartInfo)){
            //检测库存
            //如果购物车里的数量+点击的数量>库存
            if(($cartInfo[$goods_id]['buy_number']+$buy_number)>$goods_num){
                //那么点击的数量=库存
                $num=$goods_num;
            }else{
                //否则购物车里的数量+点击的数量
                $num=$cartInfo[$goods_id]['buy_number']+$buy_number;
            }
            //累加
            $cartInfo[$goods_id]['buy_number']=$num;
            $cartInfo[$goods_id]['add_time']=time();
        }else{
            //检测库存
            if($buy_number>$goods_num){
                $buy_number=$goods_num;
            }
            //添加
            $cartInfo[$goods_id]=['goods_id'=>$goods_id,'buy_number'=>$buy_number,'add_time'=>time()];
        }
        cookie('cartInfo',$cartInfo);
        successly("");
    }
}

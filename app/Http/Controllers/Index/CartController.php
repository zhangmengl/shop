<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Cart;
use App\Model\ShopGoods;

class CartController extends Controller
{
    public function checkLogin(){
        $user=session('user');
        $user_id=$user['id'];
        return $user_id;
    }
    //加入购物车
    public function addCart(Request $request){
        //接收商品id
        $goods_id=$request->input("goods_id");
        //接收购买数量
        $buy_number=$request->input("buy_number");
        // 判断用户是否登录  检测是否有，登陆时的存储session信息
        $user_id=$this->checkLogin();
        if(!empty($user_id)){
            //加入购物车  数据库
            $res=$this->addCartDb($goods_id,$buy_number);
        }else{
            //加入购物车  session
            $res=$this->addCartCookie($goods_id,$buy_number);
        }
        if($res){
            echo json_encode(['code'=>false,'font'=>'添加失败']);
        }else{
            echo json_encode(['code'=>true]);
        }
    }
     public function addCartDb($goods_id,$buy_number){
        //接收用户id
        $user=session('user');
        $user_id=$user['id'];
        //where条件
        $where=[
            ['goods_id','=',$goods_id],
            ['user_id','=',$user_id],
            ['is_del','=',1]
        ];
        //在购物车表  查一条数据
        $cartInfo=Cart::where($where)->first();
        //查询库存 
        $goods_num=ShopGoods::where('goods_id',$goods_id)->value('goods_num');
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
            $res=Cart::where($where)->update(['buy_number'=>$num,'add_time'=>time()]);
            if($res){
                return 'aaa';
            }else{
                return 'bbb';
            }
        }else{
            //检测库存
            if($buy_number>$goods_num){
                $buy_number=$goods_num;
            }
            //添加数据
            //把商品id、购买数量、加入时间、用户id存入数据库
            $info=['goods_id'=>$goods_id,'buy_number'=>$buy_number,'add_time'=>time(),'user_id'=>$user_id];
            $res=Cart::insert($info);
            if($res){
                return 'aaa';
            }else{
                return 'bbb';
            }
        }
    }
    //加入购物车
    public function addCartCookie($goods_id,$buy_number){
        $cartInfo=session('cartInfo');
        if(empty($cartInfo)){
            $cartInfo=[];
        }
        //查询库存
        $goods_num=ShopGoods::where('goods_id',$goods_id)->value('goods_num');
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
        session(['cartInfo'=>$cartInfo]);
    }
    //购物车列表
    public function cartList(){
        $user_id=$this->checkLogin();
        //判断是否登录
        if(!empty($user_id)){
            //取出购物车数据  数据库
            $cartInfo=$this->getCartDb();
        }else{
            //取出购物车数据  cookie
            $cartInfo=$this->getCartCookie();
        }
        $money=0;
        foreach($cartInfo as $k=>$v){
            $money+=$v['goods_price']*$v['buy_number'];
        }
        return view("index.cart.cart",["cartInfo"=>$cartInfo,'money'=>$money]);
    }
    //取出购物车数据  数据库
    public function getCartDb(){
        //两表联查  商品表  购物车表
        //获取用户id
        $user=session('user');
        $user_id=$user['id'];
        //where条件  用户id  购物未删除
        $where=[
            ['shop_cart.user_id','=',$user_id],
            ['is_del','=',1]
        ];
        //根据两表里共有的商品id  查找商品id，购买数量，商品名称，商品价格，商品库存，商品图片
        $cartInfo=Cart::leftjoin('shop_goods',"shop_cart.goods_id","=","shop_goods.goods_id")
                       ->where($where)
                       ->get();
        return $cartInfo->toArray();          
    }
    //取出购物车数据  cookie
    public function getCartCookie(){
        $cartInfo=session('cartInfo');
        if(!empty($cartInfo)){
            //循环处理
            foreach($cartInfo as $k=>$v){
                //根据cookie的商品id查询商品表
                $info=ShopGoods::where("goods_id",$v["goods_id"])->first();
                //将对象转换数组 toArray
                $info=$info->toArray();
                //将两个数组合并成一个数组array_merge
                $cartInfo[$k]=array_merge($v,$info);
            }
            return $cartInfo;
        }else{
            return $cartInfo=[]; 
        }
    }
    //更改购买数据
    public function changeNumber(Request $request){
        $goods_id=$request->input("goods_id");
        $buy_number=$request->input("buy_number");
        $user_id=$this->checkLogin();
        if(!empty($user_id)){
            //更改购买数量  数据库
            $res=$this->changeNumberDb($goods_id,$buy_number);
        }else{
            //更改购买数量  cookie
            $res=$this->changeNumberCookie($goods_id,$buy_number);
        }
        if($res===false){
            echo json_encode(['code'=>1,'font'=>'失败']);
        }else{
            echo json_encode(['code'=>2,'font'=>'成功']);
        }
    }
    //更改购买数量  数据库
    public function changeNumberDb($goods_id,$buy_number){
        //获取用户id
        $user=session('user');
        $user_id=$user['id'];
        //where条件  商品id  用户id  购物未删除
        $where=[
            ["goods_id","=",$goods_id],
            ["user_id","=",$user_id],
            ["is_del","=",1]
        ];
        //在购物车表中改购物车里的购买数量  原先的购买数量改为最新的购买数量
        $res=Cart::where($where)->update(["buy_number"=>$buy_number]);
        return $res;
    }
    //更改购买数量
    public function changeNumberCookie($goods_id,$buy_number){
        //取出session
        $cartInfo=session('cartInfo');
        //判断购物车数据
        if(!empty($cartInfo)){
            //根据商品id将session的值改成新值
            $cartInfo[$goods_id]["buy_number"]=$buy_number;
            //重新存入session
            session(['cartInfo'=>$cartInfo]);
            return true;
        }
    }
    //重新获取小计
    public function getTotal(Request $request){
        //获取商品id
        $goods_id=$request->input("goods_id");
        $goods_price=ShopGoods::where("goods_id",$goods_id)->value("goods_price");
        $user_id=$this->checkLogin();
        if(!empty($user_id)){
            //获取购买数量  数据库
            $buy_number=$this->getBuyNumberDb($goods_id);
        }else{
            //获取购买数量  cookie
            $buy_number=$this->getBuyNumberCookie($goods_id);
        }
        return $goods_price*$buy_number;
    }
    //获取购买数量  数据库
    public function getBuyNumberDb($goods_id){
        //获取用户id
        $user=session('user');
        $user_id=$user['id'];
        $where=[
            ["goods_id","=",$goods_id],
            ["user_id","=",$user_id],
            ["is_del","=",1]
        ];
        $buy_number=Cart::where($where)->value("buy_number");
        return $buy_number;
    }
    //获取购买数量  session
    public function getBuyNumberCookie($goods_id){
        //取出session
        $cartInfo=session('cartInfo');
        if(!empty($cartInfo)){
            //print_r($cartInfo);exit;
            //从session中取出当前商品的购买数量
            return $cartInfo[$goods_id]['buy_number'];
        }
    }
    //删除
    public function del(Request $request){
        //获取商品id
        $goods_id=$request->input("goods_id");
        $user_id=$this->checkLogin();
        //判断用户是否登录
        if(!empty($user_id)){
            //删除  数据库
            $res=$this->getDelDb($goods_id);
        }else{
            //删除  cookie
            $res=$this->getDelCookie($goods_id);
        }
        if($res){
            //删除成功
            echo json_encode(['code'=>1,'font'=>'删除成功']);
        }else{
            echo json_encode(['code'=>2,'font'=>'删除失败']);
        }
    }
    //删除  数据库
    public function getDelDb($goods_id){
        //获取用户id
        $user=session('user');
        $user_id=$user['id'];
        //where条件
        $where=[
            ["goods_id","=",$goods_id],
            ["user_id","=",$user_id],
            ["is_del","=",1]
        ];
        $res=Cart::where($where)->update(["is_del"=>2]);
        return $res;
    }
    //删除  session
    public function getDelCookie($goods_id){
        $cartInfo=session("cartInfo");
        if(!empty($cartInfo)){
            unset($cartInfo[$goods_id]);
        }
        session("cartInfo",$cartInfo);
        $aa=session('cartInfo');
        echo "<pre>";print_r($aa);echo "<pre>";die;
        return true;
    }
}
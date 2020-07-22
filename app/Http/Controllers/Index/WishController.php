<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ShopGoods as model_shopgoods;

class WishController extends Controller
{
    //收藏
    public function wish(){
        return view("index.wishlist.wishlist");
    }
    //点击收藏按钮
    public function wishDo(){
        $goods_id = request()->goods_id;
        $user_id = session("user.id");
        if(!$user_id){
            // return redirect("login/login");
            echo json_encode(["code"=>3,"msg"=>"no session"]);die;
        }else{
            $where = [
                "wish"=>1,
                "goods_id"=>$goods_id,
                "user_id"=>$user_id
            ];
            $first = model_shopgoods::where($where)->first();
            // dd($find1);
            if($first){
                echo json_encode(["code"=>2,"msg"=>"no"]);die;
            }else{
                // 收藏
                model_shopgoods::where("goods_id",$goods_id)->update(["wish"=>1,'user_id'=>$user_id]);
                echo json_encode(["code"=>1,"msg"=>"ok"]);
            }
        }    
    }
    //收藏列表
    public function wishList(){
        // $user
        // $goods_id = model_shopgoods::where("wish",1)->all();
        // dd($goods_id);
    }


}

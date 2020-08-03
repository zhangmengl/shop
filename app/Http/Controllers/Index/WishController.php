<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ShopGoods as model_shopgoods;
use App\Model\ShopVideo;

class WishController extends Controller
{
    //收藏列表
    public function wish()
    {
        $user_id = session("user.id");

        if (!$user_id) {
            return redirect("login/login");
        }

        $where = [
            "user_id" => $user_id,
            "wish" => 1,
        ];
        $res = model_shopgoods::where($where)->get()->toArray();
        if ($res==[]) {
            echo "<script>alert('暂无收藏');location.href='/'</script>";
            die;
        }
        return view("index.wishlist.wishlist", compact("res"));
    }
    //点击收藏按钮
    public function wishDo()
    {
        $goods_id = request()->goods_id;
        $user_id = session("user.id");
        if (!$user_id) {
            // return redirect("login/login");
            echo json_encode(["code"=>3,"msg"=>"no session"]);
            die;
        } else {
            $where = [
                "wish"=>1,
                "goods_id"=>$goods_id,
                "user_id"=>$user_id
            ];
            $first = model_shopgoods::where($where)->first();
            // dd($find1);
            if ($first) {
                echo json_encode(["code"=>00001,"msg"=>"no"]);
                die;
            } else {
                // 收藏
                model_shopgoods::where("goods_id", $goods_id)->update(["wish"=>1,'user_id'=>$user_id]);
            }
        }
    }
    //取消收藏
    public function wishDel()
    {
        $goods_id = request()->goods_id;
        $user_id = session("user.id");
        $where = [
            "wish"=>1,
            "goods_id"=>$goods_id,
            "user_id"=>$user_id
        ];
        $res = model_shopgoods::where($where)->update(["wish"=>0,"user_id"=>0]);
        echo json_encode(["code"=>1,"msg"=>"ok"]);
    }
   
}

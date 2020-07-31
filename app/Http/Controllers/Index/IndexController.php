<?php

namespace App\Http\Controllers\Index;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ShopGoods as model_shopgoods;
use App\Model\Cate as model_cate;
use App\Model\Video;

class IndexController extends Controller
{
    //首页
    public function index(){
        //分类查询
        $data=model_cate::get()->toArray();
        //商品查询
        $res= model_shopgoods::get()->toArray();
        return view("index.index.index",['data'=>$data,'res'=>$res]);
    }
    //列表
    public function link(){
        //分类查询
        $data=model_cate::get()->toArray();
        //商品查询
        $res= model_shopgoods::get()->toArray();
        return view('index.index.link',['data'=>$data,'res'=>$res]);
    }
    //商品详情
    public function details($id){
        // echo $id;die;
        $data= model_shopgoods::where('goods_id',$id)->find($id)->toArray();
        $aaa=Video::where('goods_id',$id)->get()->toArray();
        // print_r($aaa);die;
        if(empty($aaa)){
            return view('index.index.details',['data'=>$data]);
        }else{
            $data['goods_m3u8']=$aaa[0]['goods_m3u8'];
            return view('index.index.details',['data'=>$data]);
        }
    }
}

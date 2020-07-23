<?php

namespace App\Http\Controllers\Index;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ShopGoods as model_shopgoods;
use App\Model\Cate as model_cate;


class IndexController extends Controller
{
    //首页
    public function index(){
        //分类查询
        $data=model_cate::get()->toArray();
        //商品查询
        $res= model_shopgoods::where('is_hot','1')->get()->toArray();
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
        $data= model_shopgoods::find($id)->toArray();
        return view('index.index.details',['data'=>$data]);
    }
}

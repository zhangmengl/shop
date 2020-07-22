<?php

namespace App\Admin\Controllers;

use App\Model\ShopGoods;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class GoodsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    
    // $content->header('梦想商城后台');

    // 选填
    // $content->description('商品管理');


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ShopGoods());

        $grid->column('goods_id', __('商品id'));
        $grid->column('goods_name', __('商品名称'));
        $grid->column('goods_price', __('商品价格'));
        $grid->column('goods_num', __('商品库存'));
        $grid->column('goods_img', __('商品图片'));
        // $grid->column('goods_imgs', __('商品图集'));
        $grid->column('goods_desc', __('商品介绍'));
        $grid->column('goods_score', __('商品积分'));
        // $grid->column('is_new', __('Is new'));
        // $grid->column('is_best', __('Is best'));
        // $grid->column('is_hot', __('Is hot'));
        // $grid->column('is_up', __('Is up'));
        $grid->column('brand_id', __('品牌'));
        $grid->column('cate_id', __('分类'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ShopGoods::findOrFail($id));

        $show->field('goods_id', __('Goods id'));
        $show->field('goods_name', __('Goods name'));
        $show->field('goods_price', __('Goods price'));
        $show->field('goods_num', __('Goods num'));
        $show->field('goods_img', __('Goods img'));
        $show->field('goods_imgs', __('Goods imgs'));
        $show->field('goods_desc', __('Goods desc'));
        $show->field('goods_score', __('Goods score'));
        $show->field('is_new', __('Is new'));
        $show->field('is_best', __('Is best'));
        $show->field('is_hot', __('Is hot'));
        $show->field('is_up', __('Is up'));
        $show->field('brand_id', __('Brand id'));
        $show->field('cate_id', __('Cate id'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ShopGoods());

        $form->text('goods_name', __('商品名称'));
        $form->decimal('goods_price', __('商品价格'));
        $form->number('goods_num', __('商品库存'));
        $form->text('goods_img', __('商品图品'));
        // $form->textarea('goods_imgs', __('Goods imgs'));
        $form->textarea('goods_desc', __('商品介绍'));
        $form->number('goods_score', __('商品积分'));
        $form->switch('is_new', __('是否新品'));
        $form->switch('is_best', __('是否精品'));
        $form->switch('is_hot', __('是否热卖'));
        $form->switch('is_up', __('是否上架'));
        $form->number('brand_id', __('品牌'));
        $form->number('cate_id', __('分类'));

        return $form;
    }
}

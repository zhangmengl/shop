<?php

namespace App\Admin\Controllers;

use App\Model\Video;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class VideoController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Video';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Video());

        $grid->column('id', __('Id'));
        $grid->column('goods_id', __('Goods id'));
        $grid->column('goods_video', __('Goods video'));
        $grid->column('goods_m3u8', __('Goods m3u8'));

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
        $show = new Show(Video::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('goods_id', __('Goods id'));
        $show->field('goods_video', __('Goods video'));
        $show->field('goods_m3u8', __('Goods m3u8'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Video());

        $form->text('goods_id', __('Goods id'));
        $form->file('goods_video', __('Goods video'))->dir('video');

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Model\Cate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Cate';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Cate());

        $grid->column('cate_id', __('分类id'));
        $grid->column('cate_name', __('分类名称'));
        $grid->column('cate_show', __('是否显示'));
        $grid->column('cate_nav_show', __('是否导航栏显示'));
        $grid->column('pid', __('父级'));

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
        $show = new Show(Cate::findOrFail($id));

        $show->field('cate_id', __('Cate id'));
        $show->field('cate_name', __('Cate name'));
        $show->field('cate_show', __('Cate show'));
        $show->field('cate_nav_show', __('Cate nav show'));
        $show->field('pid', __('Pid'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Cate());

        $form->text('cate_name', __('Cate name'));
        $form->switch('cate_show', __('Cate show'));
        $form->switch('cate_nav_show', __('Cate nav show'));
        $form->number('pid', __('Pid'));

        return $form;
    }
}

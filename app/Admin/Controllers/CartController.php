<?php

namespace App\Admin\Controllers;

use App\Model\CartModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CartController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CartModel);

        $grid->id('Id');
        $grid->user_id('用户id');
        $grid->goods_id('商品id');
        $grid->cart_quantity('购买数量');
        $grid->create_time('添加时间')->display(function(){
            return date('Y-m-d H:i:s');
        });
        $grid->is_delete('回收站')->using(['1'=>'否','2'=>'是']);

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
        $show = new Show(CartModel::findOrFail($id));

        $show->id('Id');
        $show->user_id('User id');
        $show->goods_id('Goods id');
        $show->cart_quantity('Cart quantity');
        $show->create_time('Create time');
        $show->is_delete('Is delete');
        $show->update_time('Update time');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CartModel);

        $form->number('user_id', 'User id');
        $form->number('goods_id', 'Goods id');
        $form->number('cart_quantity', 'Cart quantity');
        $form->number('create_time', 'Create time');
        $form->switch('is_delete', 'Is delete')->default(1);
        $form->number('update_time', 'Update time');

        return $form;
    }
}

<?php

namespace App\Admin\Controllers;

use App\Model\Order;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OrderController extends Controller
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
        $grid = new Grid(new Order);

        $grid->oid('Oid');
        $grid->uid('Uid');
        $grid->order_no('Order no');
        $grid->order_amount('Order amount');
        $grid->order_text('Order text');
        $grid->pay_status('Pay status');
        $grid->order_status('Order status');
        $grid->create_time('Create time');
        $grid->update_time('Update time');

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
        $show = new Show(Order::findOrFail($id));

        $show->oid('Oid');
        $show->uid('Uid');
        $show->order_no('Order no');
        $show->order_amount('Order amount');
        $show->order_text('Order text');
        $show->pay_status('Pay status');
        $show->order_status('Order status');
        $show->create_time('Create time');
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
        $form = new Form(new Order);

        $form->number('uid', 'Uid');
        $form->text('order_no', 'Order no');
        $form->number('order_amount', 'Order amount');
        $form->text('order_text', 'Order text');
        $form->switch('pay_status', 'Pay status')->default(1);
        $form->switch('order_status', 'Order status')->default(1);
        $form->number('create_time', 'Create time');
        $form->number('update_time', 'Update time');

        return $form;
    }
}

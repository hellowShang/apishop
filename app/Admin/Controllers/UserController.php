<?php

namespace App\Admin\Controllers;

use App\Model\UsreModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
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
        $grid = new Grid(new UsreModel);

        $grid->uid('Uid');
        $grid->age('年龄');
        $grid->name('昵称');
        $grid->pass('密码');
        $grid->email('邮箱');
        $grid->add_time('注册时间')->display(function(){
            return date('Y-m-d H:i:s');
        });
        $grid->tel('电话');

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
        $show = new Show(UsreModel::findOrFail($id));

        $show->uid('Uid');
        $show->age('Age');
        $show->name('Name');
        $show->pass('Pass');
        $show->email('Email');
        $show->add_time('Add time');
        $show->tel('Tel');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UsreModel);

        $form->number('uid', 'Uid');
        $form->number('age', 'Age');
        $form->text('name', 'Name');
        $form->text('pass', 'Pass');
        $form->email('email', 'Email');
        $form->text('add_time', 'Add time');
        $form->text('tel', 'Tel');

        return $form;
    }
}

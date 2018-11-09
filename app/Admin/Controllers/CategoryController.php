<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CategoryController extends Controller
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
        $grid = new Grid(new Category);

        $grid->id('Id');
        $grid->name('Name');


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
        $show = new Show(Category::findOrFail($id));

        $show->id('Id');
        $show->name('Название категории');
        $show->prices('Prices');
        $show->max_count('Max students count');
        $show->description('Description');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category);

        $form->text('name', 'Name');

        $form->embeds('short_description', 'Short description', function ($form) {

            $form->text('how_often', 'How often?');
            $form->number('duration', 'Duration, weeks')->default('4 weeks');

        });

        $form->ckeditor('description', 'Description');
        $form->number('max_count', 'Max students count');

        $form->embeds('prices', 'Prices, €', function ($form) {

            $form->number('price_1', 'Price for before 4 weeks for all and between 2 and 4 weeks for students')->default(290);
            $form->number('price_2', 'Price for between 2 and 4 weeks for all, and between 1 and 2 weeks for students')->default(320);
            $form->number('price_3', 'Price for before 2 weeks for all, and 1 week for students')->default(350);

        });

        $states = [
            'on'  => ['value' => 1, 'text' => 'ON', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => 'OFF', 'color' => 'danger'],
        ];


        return $form;
    }
}

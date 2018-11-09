<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use App\Models\Contract;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CourseController extends Controller
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
            ->body($this->detail($id))
            ->row('<h3>List of students</h3>')
            ->body($this->getCourseStudents($id));
    }

    /**
     * Get students of course
     *
     * @return string
     */
    public function getCourseStudents($id) {
        $clients = '<div class="box">';
        $clients.= '<table class="table table-hover">';
        $clients.= '<tr><td>First Name</td><td>Last Name</td><td>View</td></tr>';
        $contracts = Contract::where('course_id', $id)->get();

        foreach($contracts as $contract) {

            $client = User::find($contract->user_id);
            if($client !== null) {

                $clients.= '<tr><td>'.$client->name.'</td><td>'.$client->last_name.'</td><td><a href="/admin/users/'.$client->id.'"><i class="fa fa-eye"></i></a></td></tr>';

            }

        }

        $clients.= '</table>';
        $clients.= '</div>';

        return $clients;

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
        $grid = new Grid(new Course);



        $grid->category_id('Category')->display(function($id) {
            return Category::find($id)->name;
        });
        $grid->name('Name');
        $grid->start_date('Start date');
        $grid->end_date('End date');
        $grid->filter(function($filter){

            // Remove the default id filter
            $filter->disableIdFilter();


            $categories = Category::all();


            foreach ($categories as $cat) {
                $fildata[$cat->id] = $cat->name;

            }

            $filter->in('category_id')->multipleSelect($fildata);








        });






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
        $show = new Show(Course::findOrFail($id));

        $show->category_id('Category');
        $show->name('Name');
        $show->start_date('Start date');
        $show->end_date('End date');


        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Course);

        $form->select('name', 'Name')->options([
            'A 1.1' => 'A 1.1',
            'A 1.2' => 'A 1.2',
            'A 2.1' => 'A 2.1',
            'A 2.2' => 'A 2.2',
            'B 1.1' => 'B 1.1',
            'B 1.2' => 'B 1.2',
            'B 2.1' => 'B 2.1',
            'B 2.2' => 'B 2.2',
            'TestDaf' => 'TestDaf',
        ]);
        $form->select('category_id', 'Category')
        ->options(function() {

            $items = array();
            $categories = Category::all();

            foreach ($categories as $cat) {

                $items[$cat->id] = $cat->name;

            }

            return $items;


        });


        $form->datetime('start_date', 'Start date')->default(date('Y-m-d H:i:s'));
        $form->datetime('end_date', 'End date')->default(date('Y-m-d H:i:s'));


        return $form;
    }
}

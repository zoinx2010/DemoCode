<?php

namespace App\Admin\Controllers;

use App\Http\Services\ContractService;
use App\Models\PdfLineLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use App\Support\CsvParser;
use App\Support\Contract;


class ParserController extends Controller
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
            ->header('Parse pdf')
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
        $grid = new Grid(new PdfLineLog);

        $grid->id('Id');
        $grid->document('Document');
        $grid->status('Status');
        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(PdfLineLog::findOrFail($id));

        $show->id('Id');
        $show->document('Document');
        $show->status('Status');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PdfLineLog);

        $form->file('pdf', 'Csv File');

        $form->tools(function (Form\Tools $tools) {

            // Disable back btn.
            $tools->disableBackButton();

            // Disable list btn
            $tools->disableListButton();

         });

        return $form;
    }

    /**
     * Parse pdf file
     *
     * @return void
     */
    public function store(Request $request, ContractService $contractService) {

        if ($request->hasFile('pdf')) {

            $file_path = $request->file('pdf')->getPathName();

            $records = CsvParser::parseInvoices($file_path);
            $result = $contractService->comparePrices($records);


            return view('admin.parseResult')->with('statuses',$result);

        } else {
            echo '<div class="alert alert-danger" role="alert">No file</div>';
        }
    }
}

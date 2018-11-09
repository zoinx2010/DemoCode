<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 03.11.2018
 * Time: 14:25
 */

namespace App\Http\Services;

use PDF;
use App\Models\Course;
use App\Models\Invoice;

class InvoiceService extends BaseService {

    public function __construct(Invoice $invoice) {

        $this->model = $invoice;

    }

    /**
     * Create pdf invoice
     *
     * @return void
     */
    public function createPdfInvoice($user,$contract) {

        $course = Course::find($contract->course_id);

        $data['first_name'] = $user->name;
        $data['last_name'] = $user->last_name;

        $data['contract_number'] = $contract->number;
        $data['course'] = $course->name;
        $data['start_date'] = \Carbon\Carbon::parse($course->start_date)->format('d.m.Y');
        $data['end_date'] = \Carbon\Carbon::parse($course->end_date)->format('d.m.Y');
        $data['amount'] = $contract->price;



        PDF::loadView('admin.invoice', $data)
            ->save(storage_path().'/app/invoices/'.$data['contract_number'].'.pdf');


    }

    /**
     * Download invoice
     *
     * @return download
     */
    public function download($contract_number) {

        $file = storage_path().'/app/invoices/'.$contract_number.'.pdf';

        $headers = array(
            'Content-Type: application/pdf',
        );

        return response()->download($file, 'Invoice.pdf', $headers);

    }

}
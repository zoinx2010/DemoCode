<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 03.11.2018
 * Time: 14:23
 */

namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use App\Http\Services\ClientService;
use App\Http\Services\ContractService;
use App\Http\Services\CourseService;
use App\Http\Services\InvoiceService;
use Auth;
use Illuminate\Http\Request;

class ClientController extends Controller {

    /**
     * Return contract of courses by user
     * @argument user_id
     * @return view
     */
    public function courses(ContractService $contractService, CourseService $courseSerivce) {

        $contracts = $contractService->getContractsByUser(Auth::id());
        $coursePrev = $courseSerivce->find($contracts[0]->course_id);
        $courseNext = $courseSerivce->getNextLevel($coursePrev->name);


        if($coursePrev === null) {
            throw new Exception('Course not found');
        }

        return view('pages.mycourses', [
            'contracts' => $contracts,
            'next_course' => $courseNext
        ]);

    }

    /**
     * Download invoice
     *
     * @return view
     */
    public function download(Request $request, ContractService $contractService, ClientService $clientService, InvoiceService $invoiceService) {



        if(isset($request->id)) {


            $contract = $contractService->getContractsByNumber($request->id);

            if($contract === null) {
                abort(404);
            }

            $client = $clientService->find($contract->user_id);

            if(Auth::id() == $client->id) {

                return $invoiceService->download($contract->number);

            } else {
                abort(403);
            }

        } else {

            abort(404);

        }

    }



}
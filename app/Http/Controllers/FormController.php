<?php

namespace App\Http\Controllers;

use App\Http\Services\ClientService;
use App\Http\Services\ContractService;

use App\Http\Services\CourseService;
use App\Mail\ClientRegister;
use App\Models\Course;
use App\Rules\ValidCourse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    /**
     * Register new client on Course
     *
     * @return json
     */
    public function register(Request $request, ClientService $clientService, ContractService $contractService, CourseService $courseSerivce) {


        $validator = Validator::make($request->all(),[
            'firstName' => 'required|max:14',
            'whenStart' => ['required','max:5', new ValidCourse()],
            'lastName' => 'required|max:14',
            'phone' => 'required|numeric',
            'birthDay' => 'required|date_format:m/d/Y|max:12',
            'email' => 'unique:users|required|email',
            'adress' => 'required:max:300',
        ]);

        if ($validator->fails()) {

            return \response(json_encode($validator->errors()),400);

        } else {

            //Регистрируем и авторизируем клиента
            $client = $clientService->register($request->all());

            $course = Course::find($request->whenStart);
            $category = $courseSerivce->getCategory($course->id);

            //Создаем новый контракт на заказанный ордер
            $data = array(
                'number'=> time().'-'.$client['model']->id,
                'user_id'=>$client['model']->id,
                'status'=> 'not_paid',
                'adress'=> $client['model']->adress,
                'course_id' => $course->id,
                'expired_at' => Carbon::now()->addDays(3),
                'price'=> $course->price
            );

            $contract = $contractService->create($data);

            Auth::login($client['model'], true);

            //Переменные для письма подтверждения
            $maildata = array(
              'number'=> $contract->number,
              'start_date'=> $course->start_date,
              'name_course'=> $course->name,
              'password'=> $client['password'],
              'email'=> $client['model']->email,
              'price'=> $contract->price,
              'end_date'=> $course->end_date,
              'cat_desc'=> $category->short_description,



            );

            //Отправляем письмо подтверждения клиенту
            return (new ClientRegister($maildata))->render();
            //Mail::to($client['model']->email)
             //   ->send(new ClientRegister($maildata));



            return \response('ok',200);

        }
    }


    /**
     * Register client on Course
     *
     * @return json
     */
    public function registerClient(Request $request, ClientService $clientService,ContractService $contractService) {


        $validator = Validator::make($request->all(),[
            'whenStart' => ['required','max:5', new ValidCourse()],
        ]);

        if ($validator->fails()) {

            return \response(json_encode($validator->errors()),400);

        } else {

            //Регистрируем и авторизируем клиента
            $client = $clientService->find(Auth::id());

            $course = Course::find($request->whenStart);

            //Создаем новый контракт на заказанный ордер
            $data = array(
                'number'=> time().'-'.$client->id,
                'user_id'=>$client->id,
                'status'=> 'not_paid',
                'course_id' => $course->id,
                'expired_at' => Carbon::now()->addDays(3),
                'price'=> $course->price
            );

            $contract = $contractService->create($data);

            //Отправка счета клиенту


            return \response('ok',200);

        }
    }



}

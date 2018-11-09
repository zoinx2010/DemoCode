<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 03.11.2018
 * Time: 14:25
 */

namespace App\Http\Services;

use App;
use App\Models\Contract;
use App\User;
use App\Models\AdminNotify;
use App\Notifications\InvoicePaid;

class ContractService extends BaseService {

    public function __construct(Contract $contract) {

        $this->model = $contract;

    }

    /**
     * Get contracts by user
     * @argument user_id
     * @return array Contract
     */
    public function getContractsByUser($id) {

        return Contract::where('user_id', $id)->get();

    }

    /**
     * Get contracts by number
     * @argument number
     * @return Contract
     */
    public function getContractsByNumber($number) {

        return Contract::where('number', $number)->first();

    }

    /**
     * Compare prices contract and parse array result
     *
     * @return array
     */
    public function comparePrices($parseArray) {

        $result = [];

        $invoiceService = App::make('App\Http\Services\InvoiceService');

        foreach ($parseArray as $contract_number => $amount) {


            $contract = $this->getContractsByNumber($contract_number);

            if($contract === null) {
                continue;
            }

            $user = User::find($contract->user_id);

            $course = $contract->course();

            //Если мест нет
            if(!$course->available) {


                $status = 'noPlaces';
                $adminNotify = new AdminNotify;
                $adminNotify->status = 'danger';
                $adminNotify->description = '<a target="_blank" href="/admin/users/'.$contract->user_id.'">User</a> payed('.$amount.' EURO) but course haven\'t places for him';
                $adminNotify->save();


            } else {

                if($amount == $contract->price) {
                    $status = 'payed';

                    //Меняем статус пользователей
                    $user->status = 'Confirmed';
                    $contract->status = 'paid';
                    $contract->expired_at = '2028-01-01 00:00:00';

                    $invoiceService->createPdfInvoice($user, $contract);
                    $user->notify(new InvoicePaid($contract));


                } elseif ($amount === 150) {
                    $status = 'prepayed';

                    $user->status = 'Prepayed';
                    $contract->status = 'prepaid';
                    $contract->expired_at = '2028-01-01 00:00:00';

                    $invoiceService->createPdfInvoice($user, $contract);
                    $user->notify(new InvoicePaid($contract));

                } else {
                    $status = 'wrongsumm';
                    $adminNotify = new AdminNotify;
                    $adminNotify->status = 'danger';
                    $adminNotify->description = 'Wrond summ('.$amount.' EURO) paid by <a target="_blank" href="/admin/users/'.$contract->user_id.'">user</a>';
                    $adminNotify->save();
                }

            }


            //Сохраняем статус юзера и контракта
            $user->save();
            $contract->save();

            $result[$contract->id] = array(
                'link_user' => "/admin/users/".$contract->user_id,
                'status' => $status,
                'amount' => $amount
            );


        }

        return $result;

    }



}
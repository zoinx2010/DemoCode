<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 02.11.2018
 * Time: 15:49
 */

namespace App\Http\Services;


use Illuminate\Support\Facades\Hash;
use App\User;

class ClientService extends BaseService {

    public function __construct() {

        $this->model = new User;

    }

    /**
     * Register client
     *
     * @return App\User
     */
    public function register(array $data) {

        $random_pass = str_random(10);

        $user = new User;
        $user->password = Hash::make($random_pass);
        $user->name = $data['firstName'];
        $user->email = $data['email'];
        $user->last_name = $data['lastName'];
        $user->birthday = $data['birthDay'];
        $user->phone = $data['phone'];
        $user->save();

        $data = array(
            'model' => $user,
            'password' => $random_pass
        );

        return $data;

    }


    /**
     * Check confirmation of user
     *
     * @return boolean
     */
    public function checkConfirm($id) {

        $client = $this->model->find($id);

        if($client !== null) {

            if($client->status == 'Confirmed' || $client->status == 'Prepayed') {
                return true;
            }

        } else {

            if (config('app.debug')) {
                throw new Exception('Client not found(checkconfirm)');
            } else {
                abort(500);
            }

        }

    }

}
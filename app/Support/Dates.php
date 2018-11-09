<?php
/**
 * Created by PhpStorm.
 * User: imac
 * Date: 02.11.2018
 * Time: 22:25
 */

namespace App\Support;
use Carbon\Carbon;

class Dates {

    /**
     * Returns difference beetween two dates
     *
     * @return int
     */
    public static function getDiffirenceWeeks($first,$second) {

        $difference = $first->diffInWeeks($second);

        //Проверяем чтобы курс был позднее текущего времени
        if($second < $first) {

            return $difference;


        } else {

            return false;

        }

    }

}
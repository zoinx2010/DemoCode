<?php

namespace App\Models;

use App\Http\Services\ClientService;
use App\Support\Dates;
use App\Support\Prices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Course extends Model
{
    public $timestamps = false;
    private $price;

    /**
     * Возврат категории курса
     *
     * @return Category::class
     */
    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id')->first();
    }

    /**
     * Set price course
     *
     * @return integer
     */
    public function getPriceAttribute() {

        $clientService = new ClientService();


        //Получаем цены
        $prices = $this->category()->prices;

        //Текущее время и дата начала модели
        $modelDate = Carbon::parse($this->start_date);
        $now = Carbon::now();


        $difference = Dates::getDiffirenceWeeks($modelDate,$now);

        if($difference === null) {
            return null;
        }

        //Если авторизирован и подтвержден меняется цена
        if(Auth::check() && $clientService->checkConfirm(Auth::id())) {

            $price = Prices::getPriceWithAuth($difference);

        } else {
            $price = Prices::getPrice($difference);

        }

        return $prices[$price];
    }

    /**
     * Check course available for registartion
     *
     * @return boolean
     */
    public function getAvailableAttribute() {
        $count = Contract::where('course_id', $this->id)->where('expired_at', '>', Carbon::now())->count();
        $max_count = $this->category()->max_count;

        if($count < $max_count) {
            return true;
        } else {
            return false;
        }
    }
}

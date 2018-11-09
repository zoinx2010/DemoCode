<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $casts = [
        'prices' => 'json',
        'short_description' => 'json',
    ];
    public $timestamps = false;

    /**
     * Метод возвращает объекты категории
     *
     * @return models
     */
    public function courses() {
        return $this->hasMany('App\Models\Course');
    }
}

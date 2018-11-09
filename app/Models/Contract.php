<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = ['number', 'user_id', 'status', 'course_id', 'price', 'expired_at'];

    /**
     * Returns course of contract
     *
     * @return Course::class
     */
    public function course() {
        return $this->belongsTo('App\Models\Course', 'course_id')->first();
    }
}

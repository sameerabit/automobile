<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCardDetail extends Model
{

    protected $fillable = [
        'job_card_id',
        'estimation_time',
        'job_desc',
        'employee_id',
        'type',
        'days',
        'time',
        'state' // start, pause, stop
    ];



}

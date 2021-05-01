<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = "job_card_payments";

    protected $fillable = [
        'amount',
        'job_card_id',
    ];
}

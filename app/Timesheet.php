<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = [
        'job_card_detail_id',
        'started_at',
        'ended_at'
    ];
    
}

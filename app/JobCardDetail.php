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
        'state', // start, pause, stop
    ];

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function getTimeAttribute()
    {
        $time = 0;
        foreach ($this->timesheets()->get() as $timesheet) {
            if ($timesheet->ended_at) {
                $time += ($timesheet->ended_at - $timesheet->started_at);
            } elseif ($this->state == "start") {
                $time += (round(microtime(true) * 1000) - $timesheet->started_at);
            }
        }

        return $time;
    }
}

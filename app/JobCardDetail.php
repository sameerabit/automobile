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
        'est_cost',
        'actual_cost'
    ];

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function jobCard(){
        return $this->belongsTo(JobCard::class);
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
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

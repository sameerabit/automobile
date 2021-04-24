<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HourlyRate extends Model
{
    protected $fillable = [
        'employee_id',
        'rate',
    ];

    public function employee()
    {
        $this->belongsTo(Employee::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCard extends Model
{

    protected $fillable = [
        'vehicle_id',
        'date'
    ];

    public function details(){
        return $this->hasMany(JobCardDetail::class);
    }

}

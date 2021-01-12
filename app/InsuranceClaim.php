<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceClaim extends Model
{

    protected $fillable = [
       'vehicle_id',
       'company_id',
       'agent_name',
       'date',
       'phone_1',
       'phone_2'
    ];

    public function details(){
        return $this->hasMany(InsuranceClaimDetail::class);
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
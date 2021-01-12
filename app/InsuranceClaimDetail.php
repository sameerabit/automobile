<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceClaimDetail extends Model
{

    protected $fillable = [
       'item',
       'est_cost',
       'actual_cost',
       'reason'
    ];



}

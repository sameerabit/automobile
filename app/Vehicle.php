<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'owner_name',
        'owner_phone',
        'owner_address',
        'name',
        'reg_no',
        'chassis',
        'image_url'
    ];

}


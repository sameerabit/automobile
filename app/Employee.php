<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'nic',
        'phone_1',
        'phone_2',
        'address',
        'image_url'
    ];

}


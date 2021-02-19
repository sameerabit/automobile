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

    public function getImageUrlAttribute($value){
        return $value == null ? "default.png" : $value;
    }

}


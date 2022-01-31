<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'district' //newl added to record suppliers
    ];
}

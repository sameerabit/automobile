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
        'image_url',
    ];

    protected $append = [
        'rate'
    ];

    public function getImageUrlAttribute($value)
    {
        return $value == null ? "default.png" : $value;
    }

    public function rate()
    {
        return $this->hasMany(HourlyRate::class);
    }

    public function getRateAttribute()
    {
        return $this->rate()->pluck('rate');
    }
}

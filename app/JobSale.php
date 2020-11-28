<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSale extends Model
{
    protected $fillable = [
        'job_card_id',
        'product_id',
        'quantity',
        'price',
        'return_qty',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}


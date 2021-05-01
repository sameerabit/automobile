<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobSale extends Model
{
    protected $fillable = [
        'job_card_id',
        'product_batch_id',
        'quantity',
        'price',
        'return_qty',
    ];

    public function productBatch()
    {
        return $this->belongsTo(ProductBatch::class);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierBillDetails extends Model
{
    protected $fillable = [
        'id',
        'supplier_bill_id',
        'product_id',
        'quantity',
        'unit_id',
        'buying_price',
        'selling_price',
    ];

    public function supplierBill()
    {
        return $this->belongsTo(SupplierBill::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

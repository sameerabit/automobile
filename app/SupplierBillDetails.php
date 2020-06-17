<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierBillDetails extends Model
{
    protected $fillable = [
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
}


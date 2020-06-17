<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierBill extends Model
{
    protected $fillable = [
        'supplier_id',
        'billing_date',
        'reference',
    ];

    public function supplierBillDetails(){
        return $this->hasMany(supplierBillDetails::class,'supplier_bill_id');
    }

}


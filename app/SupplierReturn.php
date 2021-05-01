<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierReturn extends Model
{
    protected $fillable = [
        'return_date',
        'reference',
        'supplier_bill_id'
    ];

    public function supplierReturnDetails()
    {
        return $this->hasMany(SupplierReturnDetails::class, 'return_id');
    }

    public function supplierBill()
    {
        return $this->belongsTo(SupplierBill::class);
    }
}

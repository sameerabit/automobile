<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierReturn extends Model
{
    protected $fillable = [
        'supplier_id',
        'return_date',
        'reference',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function supplierReturnDetails()
    {
        return $this->hasMany(supplierReturnDetails::class, 'return_id');
    }
}

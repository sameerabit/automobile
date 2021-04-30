<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductBatch extends Model
{
    protected $fillable = [
        'supplier_bill_detail_id',
        'product_id',
        'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplierBillDetail()
    {
        return $this->belongsTo(SupplierBillDetails::class);
    }

    public function sales()
    {
        return $this->hasMany(JobSale::class);
    }

    public function qty()
    {
        if($this->supplierBillDetail){
            return $this->supplierBillDetail->sum('quantity');
        }
        return 0;
    }

    public function returnQty()
    {
        if($this->supplierBillDetail){
            return $this->supplierBillDetail->sum('quantity');
        }
        return 0;
    }

    public function salesQty()
    {
        return $this->sales->sum('quantity');
    }
}

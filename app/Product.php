<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_url',
        'category_id',
        'brand_id',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplierDetails()
    {
        return $this->hasMany(SupplierBillDetails::class);
    }

    public function qty()
    {
        return $this->supplierDetails->sum('quantity');
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobSale extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $sellingPrice = $this->productBatch->supplierBillDetail ? $this->productBatch->supplierBillDetail->selling_price : 0;
        return [
            'id'         => $this->id,
            'product'    => $this->productBatch->product->name.'-'.$this->productBatch->product->brand->name.'- Rs.'. sprintf('%0.2f', $sellingPrice),
            'product_batch_id' => $this->productBatch->id,
            'return_qty' => $this->return_qty,
            'quantity'   => $this->quantity,
            'price'      => $this->price,
        ];
        // return parent::toArray($request);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobSale extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product' => $this->product->name,
            'product_id' => $this->product->id,
            'return_qty' => $this->return_qty,
            'quantity' => $this->quantity,
            'price' => $this->price,
        ];
    }
}

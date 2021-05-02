<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierReturnDetail extends JsonResource
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
        // return [
        //     "id" => 10,
        //     "return_id" => 3,
        //     "product_id" => 22,
        //     "quantity" => 1.0,
        //     "price" => 1200.0,
        //     "created_at" => "2021-05-02 02:17:14",
        //     "updated_at" => "2021-05-02 02:17:14",
        //     "deleted_at" => null
        // ];
        return parent::toArray($request);
    }
}

<?php

namespace App\Repositories;

use App\ProductBatch;
use App\SupplierBill;
use App\SupplierBillDetails;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SupplierBillRepository
{
    private $model;

    public function __construct(SupplierBill $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
        $supplierBill = new SupplierBill();
        try {
            DB::beginTransaction();
            $supplierBill->fill($data);
            $supplierBill->save();
            $supplierBill->fresh();
            $supplerBillDetails = new Collection();
            foreach (json_decode($data['supllierBillDetails'], true)  as $supplierBillDetail) {
                $supplerBillDetails->add(new SupplierBillDetails($supplierBillDetail));
            }
            $supplierBill->supplierBillDetails()->saveMany($supplerBillDetails);
            $this->insertItemBatch($supplierBill);
            DB::commit();

            return $supplierBill;
        } catch (\Exception $e) {
            DB::rollback();
        }
    }

    private function insertItemBatch(SupplierBill $supplierBill)
    {
        foreach ($supplierBill->supplierBillDetails as $detail) {
            if (!ProductBatch::where('supplier_bill_detail_id', $detail->id)->exists()) {
                $productBatch = new ProductBatch();
                $productBatch->supplier_bill_detail_id = $detail->id;
                $productBatch->quantity = $detail->quantity;
                $productBatch->product_id = $detail->product_id;
                $productBatch->save();
            }
        }
    }

    public function update(SupplierBill $supplierBill, $data)
    {
        try {
            DB::beginTransaction();

            $supplierBill->fill($data);
            $supplierBill->save();
            $supplierBill->fresh();
            $supplierBill->supplierBillDetails()->delete();
            $supplerBillDetails = new Collection();
            foreach (json_decode($data['supllierBillDetails'], true)  as $supplierBillDetail) {
                $supplerBillDetails->add(new SupplierBillDetails($supplierBillDetail));
            }
            $supplierBill->supplierBillDetails()->saveMany($supplerBillDetails);
            DB::commit();

            return $supplierBill;
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
        }
    }
}

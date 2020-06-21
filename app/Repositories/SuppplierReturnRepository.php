<?php
namespace App\Repositories; 

use App\SupplierReturn;
use App\SupplierReturnDetails;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SupplierReturnRepository{


    private $model;

    public function __construct(SupplierReturn $model)
    {
        $this->model = $model;
    }

    public function save($data)
    {
        $supplierReturn = new SupplierReturn();
        try{
            DB::beginTransaction();
        
            $supplierReturn->fill($data);
            $supplierReturn->save();
            $supplierReturn->fresh();
            $supplierReturnDetails  = new Collection();
            foreach($data['supllierBillDetails']  as $supplierReturnDetail){
                $supplierReturnDetails->add(new SupplierReturnDetails($supplierReturnDetail));
            }
            $supplierReturn->supplierReturnDetails()->saveMany($supplierReturnDetails);
            DB::commit();
            return $supplierReturn;

        }catch(\Exception $e){
            dd($e->getMessage());
            DB::rollback();
        }
        
    }

    public function update(SupplierReturn $supplierReturn, $data)
    {
        try{
            DB::beginTransaction();
        
            $supplierReturn->fill($data);
            $supplierReturn->save();
            $supplierReturn->fresh();
            $supplierReturn->supplierReturnDetails()->delete();
            $supplierReturnDetails  = new Collection();
            foreach($data['supllierBillDetails']  as $supplierReturnDetail){
                $supplierReturnDetails->add(new SupplierReturnDetails($supplierReturnDetail));
            }
            $supplierReturn->supplierReturnDetails()->saveMany($supplierReturnDetails);
            DB::commit();
            return $supplierReturn;

        }catch(\Exception $e){
            DB::rollback();
        }
        
    }



}
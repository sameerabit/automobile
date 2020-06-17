<?php

namespace App\Http\Controllers\SupplierBill;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierBill;
use App\Repositories\SupplierBillRepository;
use App\Unit;
use Illuminate\Http\Request;

class SupplierBillController extends Controller
{

    private $repository;

    public function __construct(SupplierBillRepository $supplierBillRepository)
    {
        $this->repository = $supplierBillRepository;
    }

    public function create(){
        $units = Unit::all();
        return view('supplier_bill.create',[
            'units' => $units
        ]);
    }

    public function store(Request $request){
        $supplierBill = $this->repository->save($request->all());
        return response()->json(new SupplierBill($supplierBill));
    }

}
<?php

namespace App\Http\Controllers;

use App\Unit;

class SupplierBillController extends Controller
{


    public function create(){
        $units = Unit::all();
        return view('supplier_bill.create',[
            'units' => $units
        ]);
    }

}
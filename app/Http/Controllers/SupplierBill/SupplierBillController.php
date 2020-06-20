<?php

namespace App\Http\Controllers\SupplierBill;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierBill as ResourcesSupplierBill;
use App\Repositories\SupplierBillRepository;
use App\SupplierBill;
use App\SupplierBillDetails;
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
        return response()->json(new ResourcesSupplierBill($supplierBill));
    }

    public function index()
    {
        $supplierBills = SupplierBill::paginate(15);
        return view('supplier_bill.index',[
            'supplierBills' => $supplierBills
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupplierBill  $supplier_bill
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierBill $supplier_bill)
    {
        return view('supplier_bill.show',[
            'supplier_bill' => $supplier_bill
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupplierBill  $supplier_bill
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierBill $supplier_bill)
    {
        $units = Unit::all();
        return view('supplier_bill.edit',[
            'supplierBill' => $supplier_bill,
            'units' => $units
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupplierBill  $supplier_bill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierBill $supplierBill)
    {
        $supplierBill = $this->repository->update($supplierBill, $request->all());
        return response()->json(new ResourcesSupplierBill($supplierBill));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupplierBill  $supplier_bill
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierBill $supplier_bill)
    {
        $supplier_bill->delete();
        return redirect()->route('supplier-bill.index',$supplier_bill->id)->with(
            ['success' => 'Supplier Bill Deleted Successfully']
         );
    }

    public function getSupplierBillDetails($supplier_bill_id)
    {
        $supplierBillDetails = SupplierBillDetails::where('supplier_bill_id',$supplier_bill_id)
        ->with(['product','unit'])->get();
        return response()->json($supplierBillDetails);

    }

}
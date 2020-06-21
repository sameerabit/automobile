<?php

namespace App\Http\Controllers\SupplierReturn;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierReturn as ResourcesSupplierReturn;
use App\Repositories\SupplierReturnRepository;
use App\SupplierReturn;
use App\SupplierReturnDetails;
use App\Unit;
use Illuminate\Http\Request;

class SupplierReturnController extends Controller
{

    private $repository;

    public function __construct(SupplierReturnRepository $supplierReturnRepository)
    {
        $this->repository = $supplierReturnRepository;
    }

    public function create(){
        return view('supplier_return.create',[
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'supplier_id' => 'required',
            'reference' => 'required',
            'return_date' => 'required',
        ],[
            'supplier_id.required' => 'Supplier is required'
        ]);
        $supplierReturn = $this->repository->save($request->all());
        return response()->json(new ResourcesSupplierReturn($supplierReturn));
    }

    public function index()
    {
        $supplierReturns = SupplierReturn::paginate(15);
        return view('supplier_return.index',[
            'supplierReturns' => $supplierReturns
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SupplierReturn  $supplier_return
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierReturn $supplier_return)
    {
        return view('supplier_return.show',[
            'supplier_return' => $supplier_return
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SupplierReturn  $supplier_return
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierReturn $supplier_return)
    {
        return view('supplier_return.edit',[
            'supplierReturn' => $supplier_return,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SupplierReturn  $supplier_return
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierReturn $supplierReturn)
    {
        $this->validate($request,[
            'supplier_id' => 'required',
            'reference' => 'required',
            'return_date' => 'required',
        ],[
            'supplier_id.required' => 'Supplier is required'
        ]);
        $supplierReturn = $this->repository->update($supplierReturn, $request->all());
        return response()->json(new ResourcesSupplierReturn($supplierReturn));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SupplierReturn  $supplier_return
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierReturn $supplier_return)
    {
        $supplier_return->delete();
        return redirect()->route('supplier-return.index',$supplier_return->id)->with(
            ['success' => 'Supplier Bill Deleted Successfully']
         );
    }

    public function getSupplierReturnDetails($supplier_return_id)
    {
        $supplierReturnDetails = SupplierReturnDetails::where('return_id',$supplier_return_id)
        ->with(['product'])->get();
        return response()->json($supplierReturnDetails);

    }

}
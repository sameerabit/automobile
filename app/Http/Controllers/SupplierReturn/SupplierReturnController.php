<?php

namespace App\Http\Controllers\SupplierReturn;

use App\Http\Controllers\Controller;
use App\Http\Resources\SupplierReturn as ResourcesSupplierReturn;
use App\Repositories\SupplierReturnRepository;
use App\SupplierBill;
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

    public function create()
    {
        return view('supplier_return.create', [
        ]);
    }

    public function createReturn($bill_id)
    {
        $supplierReturn = SupplierReturn::where('supplier_bill_id',$bill_id)->first();
        if($supplierReturn == null){
            $supplierReturn = new SupplierReturn();
            $supplierReturn->supplier_bill_id = $bill_id;
            $supplierReturn->reference = time() . rand(10 * 45, 100 * 98);
            $supplierReturn->return_date = date('Y-m-d');
            $supplierReturn->save();
            $supplierReturn->fresh();
        }
        return redirect()->route('supplier-returns.edit',$supplierReturn->id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'reference'   => 'required',
            'return_date' => 'required',
        ]);
        $supplierReturn = $this->repository->save($request->all());

        return response()->json(new ResourcesSupplierReturn($supplierReturn));
    }

    public function index(Request $request)
    {
        $supplierReturns = SupplierReturn::whereHas('supplierBill',function($query) use ($request) {
            if($request->has('q') && $request->q){
                $query->whereHas('supplier',function($query) use ($request) {
                    $query->where('name','like',"%$request->q%");
                });
            }
        })->paginate(15);

        return view('supplier_return.index', [
            'supplierReturns' => $supplierReturns,
            'term' => $request->q
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\SupplierReturn $supplier_return
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SupplierReturn $supplier_return)
    {
        return view('supplier_return.show', [
            'supplier_return' => $supplier_return,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\SupplierReturn $supplier_return
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(SupplierReturn $supplierReturn)
    {
        return view('supplier_return.edit', [
            'supplierReturn' => $supplierReturn,
            'bill_id' => $supplierReturn->supplier_bill_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\SupplierReturn      $supplier_return
     * @param SupplierReturn           $supplierReturn
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SupplierReturn $supplierReturn)
    {
        $this->validate($request, [
            'reference'   => 'required',
            'return_date' => 'required',
        ]);
        $supplierReturn = $this->repository->update($supplierReturn, $request->all());

        return response()->json(new ResourcesSupplierReturn($supplierReturn));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\SupplierReturn $supplier_return
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupplierReturn $supplier_return)
    {
        $supplier_return->delete();

        return redirect()->route('supplier-return.index', $supplier_return->id)->with(
            ['success' => 'Supplier Bill Deleted Successfully']
         );
    }

    public function getSupplierReturnDetails($supplier_return_id)
    {
        $supplierReturnDetails = SupplierReturnDetails::where('return_id', $supplier_return_id)
        ->with(['product'])->get();

        return response()->json($supplierReturnDetails);
    }

}

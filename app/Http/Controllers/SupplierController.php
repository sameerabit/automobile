<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Supplier::query();
        if($request->has('q') && $request->q){
            $query->where('name','like',"%$request->q%");
            $query->orWhere('phone','like',"%$request->q%");
        }
        $suppliers = $query->paginate(15);
        return view('supplier.index',[
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = new Supplier();
        return view('supplier.create',[
            'supplier' => $supplier
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'phone' => 'numeric'
        ]);
        $supplier = new Supplier();
        $supplier->fill($request->all());
        $supplier->save();
        $supplier->fresh();
        return redirect()->route('suppliers.show',$supplier->id)->with(
           ['success' => 'Supplier Saved Successfully']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('supplier.show',[
            'supplier' => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('supplier.edit',[
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request,[
            'name' => 'required',
            'phone' => 'numeric'
        ]);
        $supplier->fill($request->all());
        $supplier->save();
        $supplier->fresh();
        return redirect()->route('suppliers.show',$supplier->id)->with(
           ['success' => 'Supplier Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index',$supplier->id)->with(
            ['success' => 'Supplier Deleted Successfully']
         );
    }

    public function searchByName(Request $request)
    {
        $query = Supplier::query();
        if($request->has('q') && $request->q){
            $query->where('name','like',"%$request->q%");
        }
        $products = $query->get();
        return response([
            "items"=>$products,
            "total_count"=> $products->count()
        ]);
    }

    
}

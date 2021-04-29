<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Resources\ProductCollection;
use App\Product;
use App\ProductBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $products = $query->paginate(15);

        return view('product.index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product    = new Product();
        $categories = Category::all();
        $brands     = Brand::all();

        return view('product.create', [
            'product'    => $product,
            'categories' => $categories,
            'brands'     => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:2048',
        ]);
        $product = new Product();
        $product->fill($request->all());
        if ($request->file('image')) {
            Storage::disk('public')->put($request->image->hashName(), File::get($request->image));
            $product->image_url = $request->image->hashName();
        }
        $product->save();
        $product->fresh();

        return redirect()->route('products.show', $product->id)->with(
           ['success' => 'Product Saved Successfully']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands     = Brand::all();

        return view('product.edit', [
            'product'    => $product,
            'categories' => $categories,
            'brands'     => $brands,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product             $product
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $product->fill($request->all());
        if ($request->file('image')) {
            Storage::disk('public')->put($request->image->hashName(), File::get($request->image));
            $product->image_url = $request->image->hashName();
        }
        $product->save();
        $product->fresh();

        return redirect()->route('products.show', $product->id)->with(
           ['success' => 'Product Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index', $product->id)->with(
            ['success' => 'Product Deleted Successfully']
         );
    }

    public function searchByName(Request $request)
    {
        $query = Product::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $products = $query->get();

        return response([
            "items"       => new ProductCollection($products),
            "total_count" => $products->count(),
        ]);
    }

    public function searchProductBatchByProductName(Request $request)
    {
        $query = DB::table('product_batches')
        ->select('product_batches.id',DB::raw("CONCAT(products.name,'   -   ',brands.name,'   -    Rs. ',supplier_bill_details.selling_price) as name"),
        'product_batches.id','supplier_bill_details.quantity','supplier_bill_details.selling_price')
        ->join('products','product_batches.product_id','=','products.id')
        ->join('supplier_bill_details','supplier_bill_details.id','=','product_batches.supplier_bill_detail_id')
        ->join('brands','brands.id','=','products.brand_id')
        ->where('product_batches.quantity','>',0);
        if ($request->has('q') && $request->q) {
            $query->where('products.name', 'like', "%$request->q%");
        }
        $productBatches = $query->get();
        return response([
            "items"       => $productBatches,
            "total_count" => $productBatches->count(),
        ]);
    }

    public function searchByBillId(Request $request,$bill_id)
    {
        $query = DB::table('products')->join('supplier_bill_details','supplier_bill_details.product_id','=','products.id')
        ->where('supplier_bill_details.supplier_bill_id',$bill_id)
        ->select('products.*')->groupBy('products.id');
        if ($request->has('q') && $request->q) {
            $query->where('products.name', 'like', "%$request->q%");
        }
        $products = $query->get();
        return response([
            "items"       => $products,
            "total_count" => $products->count(),
        ]);
    }

    public function allJson(Request $request)
    {
        $query    = Product::query();
        $products = $query->get();

        return response([
            "items"       => $products,
            "total_count" => $products->count(),
        ]);
    }
}

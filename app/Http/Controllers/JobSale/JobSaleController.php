<?php

namespace App\Http\Controllers\JobSale;

use App\Events\StockAdjust;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobSaleCollection;
use App\JobSale;
use App\Product;
use App\ProductBatch;
use Illuminate\Http\Request;

class JobSaleController extends Controller
{
    public function getJobSale($id)
    {
        $jobSales = JobSale::where('job_card_id', $id)->get();

        return response()->json(new JobSaleCollection($jobSales));
    }

    public function store(Request $request)
    {
        $productBatch = ProductBatch::find($request->product_batch_id);
        if (!$productBatch) {
            $product              = new Product();
            $product->name        = $request->product_batch_id; //product id is the name here.
            $product->category_id = 1; //product id is the name here.
            $product->brand_id    = 1; //product id is the name here.
            $product->save();
            $product->fresh();

            $productBatch = new ProductBatch();
            $productBatch->supplier_bill_detail_id = 0;
            $productBatch->quantity = $request->quantity;
            $productBatch->product_id = $product->id;
            $productBatch->save();
            $productBatch->fresh();
        }
        $jobSale = new JobSale();
        $jobSale->fill($request->all());
        $jobSale->product_batch_id = $productBatch->id;
        $jobSale->save();
        $jobSale->fresh();
        event(new StockAdjust($productBatch, (-$jobSale->quantity)));
        return response()->json($jobSale);
    }

    public function update(Request $request, JobSale $jobSale)
    {
        $productBatch = ProductBatch::find($request->product_batch_id);
        $qtyChnage = $jobSale->quantity - $request->quantity;
        $jobSale->fill($request->all());
        $jobSale->product_batch_id = $productBatch->id;
        $jobSale->save();
        $jobSale->fresh();
        event(new StockAdjust($productBatch, $qtyChnage));
        return response()->json($jobSale);
    }

    public function delete(JobSale $jobSale)
    {
        $jobSale->delete();
        return response()->json($jobSale);
    }
}

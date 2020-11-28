<?php

namespace App\Http\Controllers\JobSale;

use App\Http\Controllers\Controller;
use App\JobSale;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\JobSale as JobSaleResource;

class JobSaleController extends Controller
{

    public function getJobSale($id)
    {
        $jobSales = JobSale::where('job_card_id',$id)->get();
        return response()->json(JobSaleResource::collection($jobSales));
    }

    public function store(Request $request){
        $product = Product::find($request->product_id);
        if(!$product){
            $product = new Product();
            $product->name = $request->product_id; //product id is the name here.
            $product->save();
            $product->fresh();
        }
        $jobSale = new JobSale();
        $jobSale->fill($request->all());
        $jobSale->product_id = $product->id;
        $jobSale->save();
        $jobSale->fresh();
        return response()->json($jobSale);
    }
}

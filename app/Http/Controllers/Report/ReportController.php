<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\JobSale;
use App\ProductBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function products()
    {
        $productBatches = ProductBatch::get();
        return view('reports.products', [
            'productBatches' => $productBatches,
        ]);
    }

    public function dailyBusinessReport(Request $request){
        $jobCardDetails = DB::table('job_card_details')
        ->join('employees','employees.id','job_card_details.employee_id')
        ->select('job_card_details.*','employees.id','employees.name as employee_name')
        ->whereDate('job_card_details.created_at',$request->date)->get();

        $jobSales = DB::table('job_sales')
        ->join('product_batches','product_batches.id','job_sales.product_batch_id')
        ->join('products','products.id','product_batches.product_id')
        ->select('job_sales.*','products.name')
        ->whereDate('job_sales.created_at',$request->date)->get();

        $payments = DB::table('job_card_payments')
        ->select('job_card_payments.*','vehicles.owner_name')
        ->join('job_cards','job_cards.id','job_card_payments.job_card_id')
        ->join('vehicles','vehicles.id','job_cards.vehicle_id')
        ->whereDate('job_card_payments.created_at',$request->date)->get();

        return view('reports.daily_business', [
            'jobCardDetails' => $jobCardDetails,
            'jobSales' => $jobSales,
            'payments' => $payments,
            'date' => $request->date
        ]);
    }

}
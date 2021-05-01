<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\JobSale;
use App\ProductBatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

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

        if ($request->has('export')) {
            if ($request->get('export') == 'pdf') {
                PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
                $opciones_ssl=array(
                    "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                    ),
                    );
                    $img_path = public_path('uploads/logo.jpg');
                    $extencion = pathinfo($img_path, PATHINFO_EXTENSION);
                    $data = file_get_contents($img_path, false, stream_context_create($opciones_ssl));
                    $img_base_64 = base64_encode($data);
                    $image_path = 'data:image/' . $extencion . ';base64,' . $img_base_64;
                $pdf = PDF::loadView('reports.daily-biz', [
                    'jobCardDetails' => $jobCardDetails,
                    'jobSales' => $jobSales,
                    'payments' => $payments,
                    'date' => $request->date,
                    'image_path' => $image_path

                ]);
                return $pdf->download(date('Y-m-d H:i:s').'daily_sales.pdf');
            }
        }

        return view('reports.daily_business', [
            'jobCardDetails' => $jobCardDetails,
            'jobSales' => $jobSales,
            'payments' => $payments,
            'date' => $request->date
        ]);
    }

}
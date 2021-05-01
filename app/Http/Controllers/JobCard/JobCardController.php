<?php

namespace App\Http\Controllers\JobCard;

use App\Http\Controllers\Controller;
use App\JobCard;
use App\Payment;
use App\Vehicle;
use Exception;
use Illuminate\Http\Request;
use PDF;


class JobCardController extends Controller
{
    public function create()
    {
        $vehicles = Vehicle::all();

        return view('job_card.create', [
            'vehicles' => $vehicles,
        ]);
    }

    public function store(Request $request)
    {
        $jobCard = new JobCard();
        $jobCard->fill($request->all());
        $jobCard->save();

        return response()->json($jobCard);
    }

    public function edit(JobCard $jobCard)
    {
        $vehicles = Vehicle::all();

        return view('job_card.edit', [
            'vehicles' => $vehicles,
            'jobCard'  => $jobCard,
        ]);
    }

    public function index(Request $request)
    {
        $jobCardQuery = JobCard::with('vehicle');
        // if($request->has('q') && $request->q){
        //     $jobCardQuery->where('vehicle_no','like',"%$request->q%");
        //     $jobCardQuery->orWhere('vehicle_no','like',"%$request->q%");
        // }
        $jobCards = $jobCardQuery->orderBy('id', 'DESC')->paginate();

        // $jobCards = $jobCards->filter(function($jobCard){
        //     return $jobCard->paymentStatus() == 0;
        // });


        return view('job_card.index', [
            'jobCards' => $jobCards,
        ]);
    }

    public function destroy(JobCard $jobCard)
    {
        $jobCard->delete();

        return redirect()->route('job_cards.index')->with(
            ['success' => 'Job Card Deleted Successfully']
         );
    }

    public function createBill(JobCard $jobCard, Request $request)
    {
        $jobCard->totalServicePrice();
        $vehicles = Vehicle::all();
        foreach($jobCard->details()->get() as $detail){
            if ($detail->state == "start") {

                return back()->with(
                    ['warning' => 'Still there are task with START status. Please stop them to proceed.']
                );
            }
        }
        try{
            foreach($jobCard->details as $detail){
                $detail->est_cost = $detail->employee->rate[0]*$detail->estimation_time;
                $detail->actual_cost = $detail->employee->rate[0]* ($detail->time == null ? 0 : $detail->time) /(1000*60*60);
                $detail->save();
            }
        } catch(Exception $ex){
            return back()->with([
                'warning' => "Add Hour rates to the employee before making the bill."
            ]);
        }
        

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
                $pdf = PDF::loadView('job_card.pdf', [
                    'jobCard'  => $jobCard,
                    'image_path' => $image_path
                ]);
                return $pdf->download('job_card.pdf');
            }
        }

        return view('job_card.bill', [
            'vehicles' => $vehicles,
            'jobCard'  => $jobCard,
        ]);
    }


    public function pay(Request $request){
        $payment = new Payment();
        $payment->job_card_id = $request->job_card_id;
        $payment->amount = $request->amount;
        $payment->save();
        return back()->with([
            'Payment done.'
        ]);
    }
}

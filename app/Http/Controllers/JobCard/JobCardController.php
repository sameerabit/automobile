<?php

namespace App\Http\Controllers\JobCard;

use App\Http\Controllers\Controller;
use App\JobCard;
use App\Vehicle;
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
        $vehicles = Vehicle::all();
        foreach($jobCard->details()->get() as $detail){
            if ($detail->state == "start") {

                return back()->with(
                    ['warning' => 'Still there are task with START status. Please stop them to proceed.']
                );
            }
        }
        foreach($jobCard->details as $detail){
            $detail->est_cost = $detail->employee->rate[0]*$detail->estimation_time;
            $detail->actual_cost = $detail->employee->rate[0]* ($detail->time == null ? 0 : $detail->time) /(1000*60*60);
            $detail->save();
        }

        if ($request->has('export')) {
            if ($request->get('export') == 'pdf') {
                PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
               
                $pdf = PDF::loadView('job_card.pdf', [
                    'jobCard'  => $jobCard,
                ]);
                return $pdf->download('job_card.pdf');
            }
        }

        return view('job_card.bill', [
            'vehicles' => $vehicles,
            'jobCard'  => $jobCard,
        ]);
    }
}

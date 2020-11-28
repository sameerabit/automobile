<?php

namespace App\Http\Controllers\JobCard;

use App\Http\Controllers\Controller;
use App\JobCard;
use App\Vehicle;
use Illuminate\Http\Request;

class JobCardController extends Controller
{

    public function create()
    {
        $vehicles = Vehicle::all();
        return view('job_card.create',[
            'vehicles' => $vehicles
        ]);
    }

    public function store(Request $request)
    {
        $jobCard = new JobCard();
        $jobCard->fill($request->all());
        $jobCard->save();
        return response()->json($jobCard);
    }

    public function edit(JobCard $jobCard){
        $vehicles = Vehicle::all();
        return view('job_card.edit',[
            'vehicles' => $vehicles,
            'jobCard' => $jobCard
        ]);
    }

    public function index(Request $request)
    {
        $jobCardQuery = JobCard::with('vehicle');
        // if($request->has('q') && $request->q){
        //     $jobCardQuery->where('vehicle_no','like',"%$request->q%");
        //     $jobCardQuery->orWhere('vehicle_no','like',"%$request->q%");
        // }
        $jobCards = $jobCardQuery->orderBy('id','DESC')->paginate();
        return view('job_card.index',[
            'jobCards' => $jobCards
        ]);
    }

    public function destroy(JobCard $jobCard){
        $jobCard->delete();
        return redirect()->route('job_cards.index')->with(
            ['success' => 'Job Card Deleted Successfully']
         );
    }




}

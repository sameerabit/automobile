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




}

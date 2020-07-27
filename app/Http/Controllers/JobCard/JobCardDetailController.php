<?php

namespace App\Http\Controllers\JobCard;

use App\Http\Controllers\Controller;
use App\JobCard;
use App\JobCardDetail;
use App\Vehicle;
use Illuminate\Http\Request;

class JobCardDetailController extends Controller
{

    public function store(Request $request)
    {
        $jobCardDetails = new JobCardDetail();
        $jobCardDetails->fill($request->all());
        $jobCard = JobCard::find($request->job_card_id);
        $jobCard->details()->save($jobCardDetails);
        return response()->json($jobCard);
    }




}
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
        return response()->json($jobCardDetails);
    }

    public function getJobDetailsFromJobCardId($job_card_id,Request $request)
    {
        $jobCardDetailsQuery = JobCardDetail::where('job_card_id',$job_card_id);
        if($request->has('type') && $request->type){
            $jobCardDetailsQuery->where('type',$request->type);
        }
        $jobCardDetails = $jobCardDetailsQuery->get();
        return response()->json($jobCardDetails);
    }

    public function destroy(JobCardDetail $jobCardDetail){
        $jobCardDetail->delete();
        return response()->json(["data" => 1]);
    }

    public function update(JobCardDetail $jobCardDetail,Request $request){
        $jobCardDetail->fill($request->all());
        $jobCardDetail->save();
        return response()->json($jobCardDetail);
    }





}

<?php

namespace App\Http\Controllers\JobCard;

use App\Http\Controllers\Controller;
use App\Http\Resources\JobCardDetailCollection;
use App\JobCard;
use App\JobCardDetail;
use App\Timesheet;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

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

    public function getJobDetailsFromJobCardId($job_card_id, Request $request)
    {
        $jobCardDetailsQuery = JobCardDetail::where('job_card_id', $job_card_id);
        if ($request->has('type') && $request->type) {
            $jobCardDetailsQuery->where('type', $request->type);
        }
        $jobCardDetails = $jobCardDetailsQuery->get();

        return response()->json(new JobCardDetailCollection($jobCardDetails));
    }

    public function destroy(JobCardDetail $jobCardDetail)
    {
        $jobCardDetail->delete();

        return response()->json(["data" => 1]);
    }

    public function update(JobCardDetail $jobCardDetail, Request $request)
    {
        $jobCardDetail->fill($request->all());
        $jobCardDetail->save();

        return response()->json($jobCardDetail);
    }

    public function updateTime(JobCardDetail $jobCardDetail, Request $request)
    {
        $timesheet = Timesheet::where("job_card_detail_id", $jobCardDetail->id)
                    ->whereNull('ended_at')
                    ->latest('id')->first();
        if (!$timesheet) {
            $timesheet                     = new Timesheet();
            $timesheet->job_card_detail_id = $jobCardDetail->id;
            $timesheet->started_at         = $request->time;
            $timesheet->save();
        } elseif ($jobCardDetail->state == "start" && $timesheet->ended_at == null) {
            $timesheet->ended_at = $request->time;
            $timesheet->save();
        }
        $jobCardDetail->state = $request->state;
        $jobCardDetail->save();
        $message = "Hello {$jobCardDetail->jobCard->vehicle->owner_name}, We just started repairing your vehicle {$jobCardDetail->jobCard->vehicle->reg_no}. We'll Notify you once done. Thank you. ";
        
        $this->sendMessage($message, $jobCardDetail->jobCard->vehicle->owner_phone);

        return response()->json($jobCardDetail);
    }

    public function findJson(JobCardDetail $jobCardDetail)
    {
        return response()->json($jobCardDetail);
    }


/**
 * Sends sms to user using Twilio's programmable sms client
 * @param String $message Body of sms
 * @param Number $recipients string or array of phone number of recepient
 */
private function sendMessage($message, $recipients)
{
    $account_sid = getenv("TWILIO_SID");
    $auth_token = getenv("TWILIO_AUTH_TOKEN");
    $twilio_number = getenv("TWILIO_NUMBER");
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($recipients, 
            ['from' => $twilio_number, 'body' => $message] );
}
}

<?php

namespace App\Http\Controllers\InsuranceClaim;

use App\Http\Controllers\Controller;
use App\Http\Resources\InsuranceClaimDetailCollection;
use App\InsuranceClaim;
use App\InsuranceClaimDetail;
use Illuminate\Http\Request;

class InsuranceClaimDetailsController extends Controller
{
    public function store(Request $request)
    {
        $insuranceClaimDetails = new InsuranceClaimDetail();
        $insuranceClaimDetails->fill($request->all());
        $jobCard = InsuranceClaim::find($request->insurance_claim_id);
        $jobCard->details()->save($insuranceClaimDetails);

        return response()->json($insuranceClaimDetails);
    }

    public function getInsuranceClaimDetailsFromInsuranceClaimId($insurance_claim_id, Request $request)
    {
        $insuranceClaimDetailsQuery = InsuranceClaimDetail::where('insurance_claim_id', $insurance_claim_id);
        $insuranceClaimDetails      = $insuranceClaimDetailsQuery->get();

        return response()->json(new InsuranceClaimDetailCollection($insuranceClaimDetails));
    }

    public function destroy(InsuranceClaimDetail $insuranceClaimDetail)
    {
        $insuranceClaimDetail->delete();

        return response()->json(["data" => 1]);
    }

    public function update(InsuranceClaimDetail $insuranceClaimDetail, Request $request)
    {
        $insuranceClaimDetail->fill($request->all());
        $insuranceClaimDetail->save();

        return response()->json($insuranceClaimDetail);
    }

    public function updateTime(InsuranceClaimDetail $insuranceClaimDetail, Request $request)
    {
        $insuranceClaimDetail->fill($request->all());
        $insuranceClaimDetail->save();

        return response()->json($insuranceClaimDetail);
    }

    public function findJson(InsuranceClaimDetail $insuranceClaimDetail)
    {
        return response()->json($insuranceClaimDetail);
    }
}

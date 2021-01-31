<?php

namespace App\Http\Controllers\InsuranceClaim;

use App\Vehicle;
use App\InsuranceClaim;
use App\InsuranceCompany;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InsuranceClaimController extends Controller
{

    public function create()
    {
        $insuranceCompanies = InsuranceCompany::all();
        $vehicles = Vehicle::all();
        return view('insurance_claim.create',[
            'vehicles' => $vehicles,
            'insurance_companies' => $insuranceCompanies
        ]);
    }

    public function store(Request $request)
    {
        $insuranceClaim = new InsuranceClaim();
        $insuranceClaim->fill($request->all());
        $insuranceClaim->save();
        return response()->json($insuranceClaim);
    }

    public function edit(InsuranceClaim $insuranceClaim){
        $vehicles = Vehicle::all();
        $insuranceCompanies = InsuranceCompany::all();
        return view('insurance_claim.edit',[
            'vehicles' => $vehicles,
            'insuranceClaim' => $insuranceClaim,
            'insurance_companies' => $insuranceCompanies
        ]);
    }

    public function index(Request $request)
    {
        $insuranceClaimQuery = InsuranceClaim::with('vehicle');
        // if($request->has('q') && $request->q){
        //     $insuranceClaimQuery->where('vehicle_no','like',"%$request->q%");
        //     $insuranceClaimQuery->orWhere('vehicle_no','like',"%$request->q%");
        // }
        $insuranceClaims = $insuranceClaimQuery->orderBy('id','DESC')->paginate();
        return view('insurance_claim.index',[
            'insuranceClaims' => $insuranceClaims
        ]);
    }

    public function destroy(InsuranceClaim $insuranceClaim){
        $insuranceClaim->delete();
        return redirect()->route('insurance_claim.index')->with(
            ['success' => 'Insurance Claim Deleted Successfully']
         );
    }




}

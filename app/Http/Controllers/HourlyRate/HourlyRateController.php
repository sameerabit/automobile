<?php

namespace App\Http\Controllers\HourlyRate;

use App\HourlyRate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HourlyRateController extends Controller
{

    public function create()
    {
        return view('employee.hourly_rate', [
        ]);
    }

    public function store(Request $request)
    {
        $hourlyRate = new HourlyRate();
        $hourlyRate->fill($request->all());
        $hourlyRate->save();
        return response()->json($hourlyRate);
    }

    public function index()
    {
        $hourlyRates = HourlyRate::all();
        return response()->json($hourlyRates);
    }

    public function destroy(HourlyRate $hourlyRate)
    {
        $hourlyRate->delete();

        return response()->json(["data" => 1]);
    }

    public function update(HourlyRate $hourlyRate, Request $request)
    {
        $hourlyRate->fill($request->all());
        $hourlyRate->save();

        return response()->json($hourlyRate);
    }


    public function findJson(HourlyRate $hourlyRate)
    {
        return response()->json($hourlyRate);
    }
}

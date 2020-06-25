<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Vehicle::query();
        if($request->has('q') && $request->q){
            $query->where('name','like',"%$request->q%");
        }
        $vehicles = $query->paginate(15);
        return view('vehicle.index',[
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle = new Vehicle();
        return view('vehicle.create',[
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:2048',
            'owner_name' => 'required',
            'owner_phone' => 'numeric',
            'reg_no' => 'required',

        ]);
        $vehicle = new Vehicle();
        $vehicle->fill($request->all());
        if($request->file('image')){
            Storage::disk('public')->put($request->image->hashName(), File::get($request->image));
            $vehicle->image_url = $request->image->hashName();
        }
        $vehicle->save();
        $vehicle->fresh();
        return redirect()->route('vehicles.show',$vehicle->id)->with(
           ['success' => 'Vehicle Saved Successfully']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicle.show',[
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicle.edit',[
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->validate($request,[
            'name' => 'required',
        ]);
        $vehicle->fill($request->all());
        if($request->file('image')){
            Storage::disk('public')->put($request->image->hashName(), File::get($request->image));
            $vehicle->image_url = $request->image->hashName();
        }
        $vehicle->save();
        $vehicle->fresh();
        return redirect()->route('vehicles.show',$vehicle->id)->with(
           ['success' => 'Vehicle Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index',$vehicle->id)->with(
            ['success' => 'Vehicle Deleted Successfully']
         );
    }

    public function searchByName(Request $request)
    {
        $query = Vehicle::query();
        if($request->has('q') && $request->q){
            $query->where('name','like',"%$request->q%");
        }
        $vehicles = $query->get();
        return response([
            "items"=>$vehicles,
            "total_count"=> $vehicles->count()
        ]);
    }
}

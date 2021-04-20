<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Unit::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $units = $query->paginate(15);

        return view('unit.index', [
            'units' => $units,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unit = new Unit();

        return view('unit.create', [
            'unit' => $unit,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required',
            'abbreviation' => 'required',
        ]);
        $unit = new Unit();
        $unit->fill($request->all());
        $unit->save();
        $unit->fresh();

        return redirect()->route('units.show', $unit->id)->with(
           ['success' => 'Unit Saved Successfully']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Unit $unit
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        return view('unit.show', [
            'unit' => $unit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Unit $unit
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Unit $unit)
    {
        return view('unit.edit', [
            'unit' => $unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Unit                $unit
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
        $this->validate($request, [
            'name'         => 'required',
            'abbreviation' => 'required',
        ]);
        $unit->fill($request->all());
        $unit->save();
        $unit->fresh();

        return redirect()->route('units.show', $unit->id)->with(
           ['success' => 'Unit Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Unit $unit
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('units.index', $unit->id)->with(
            ['success' => 'Unit Deleted Successfully']
         );
    }
}

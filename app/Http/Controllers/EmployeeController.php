<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Employee::query();
        if($request->has('q') && $request->q){
            $query->where('name','like',"%$request->q%");
        }
        $employees = $query->paginate(15);
        return view('employee.index',[
            'employees' => $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee = new Employee();
        return view('employee.create',[
            'employee' => $employee,
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
            'phone' => 'numeric',
            'address' => 'required',
            'nic' => 'required',
        ]);
        $employee = new Employee();
        $employee->fill($request->all());
        if($request->file('image')){
            Storage::disk('public')->put($request->image->hashName(), File::get($request->image));
            $employee->image_url = $request->image->hashName();
        }
        $employee->save();
        $employee->fresh();
        return redirect()->route('employees.show',$employee->id)->with(
           ['success' => 'Employee Saved Successfully']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employee.show',[
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit',[
            'employee' => $employee,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request,[
            'name' => 'required',
            'image' => 'mimes:jpg,jpeg,png|max:2048',
            'phone' => 'numeric',
            'address' => 'required',
            'nic' => 'required',
        ]);
        $employee->fill($request->all());
        if($request->file('image')){
            Storage::disk('public')->put($request->image->hashName(), File::get($request->image));
            $employee->image_url = $request->image->hashName();
        }
        $employee->save();
        $employee->fresh();
        return redirect()->route('employees.show',$employee->id)->with(
           ['success' => 'Employee Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index',$employee->id)->with(
            ['success' => 'Employee Deleted Successfully']
         );
    }

    public function searchByName(Request $request)
    {
        $query = Employee::query();
        if($request->has('q') && $request->q){
            $query->where('name','like',"%$request->q%");
        }
        $employees = $query->get();
        return response([
            "items"=>$employees,
            "total_count"=> $employees->count()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\InsuranceCompany;
use Illuminate\Http\Request;

class InsuranceCompanyController extends Controller
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
        $query = InsuranceCompany::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
            $query->orWhere('phone', 'like', "%$request->q%");
        }
        $insurance_companies = $query->paginate(15);

        return view('insurance_company.index', [
            'insurance_companies' => $insurance_companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insurance_company = new InsuranceCompany();

        return view('insurance_company.create', [
            'insurance_company' => $insurance_company,
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
            'name'  => 'required',
            'phone' => 'numeric',
        ]);
        $insurance_company = new InsuranceCompany();
        $insurance_company->fill($request->all());
        $insurance_company->save();
        $insurance_company->fresh();

        return redirect()->route('insurance_companies.show', $insurance_company->id)->with(
           ['success' => 'Insurance Company Saved Successfully']
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\InsuranceCompany $insurance_company
     *
     * @return \Illuminate\Http\Response
     */
    public function show(InsuranceCompany $insurance_company)
    {
        return view('insurance_company.show', [
            'company' => $insurance_company,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\InsuranceCompany $insurance_company
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(InsuranceCompany $insurance_company)
    {
        return view('insurance_company.edit', [
            'insurance_company' => $insurance_company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\InsuranceCompany    $insurance_company
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsuranceCompany $insurance_company)
    {
        $this->validate($request, [
            'name'  => 'required',
            'phone' => 'numeric',
        ]);
        $insurance_company->fill($request->all());
        $insurance_company->save();
        $insurance_company->fresh();

        return redirect()->route('insurance_companies.show', $insurance_company->id)->with(
           ['success' => 'Insurance Company Updated Successfully']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\InsuranceCompany $insurance_company
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsuranceCompany $insurance_company)
    {
        $insurance_company->delete();

        return redirect()->route('insurance_companies.index', $insurance_company->id)->with(
            ['success' => 'InsuranceCompany Deleted Successfully']
         );
    }

    public function searchByName(Request $request)
    {
        $query = InsuranceCompany::query();
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', "%$request->q%");
        }
        $products = $query->get();

        return response([
            "items"       => $products,
            "total_count" => $products->count(),
        ]);
    }
}

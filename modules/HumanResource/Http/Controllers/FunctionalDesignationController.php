<?php

namespace Modules\HumanResource\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Modules\HumanResource\Entities\FunctionalDesignation;
use Modules\HumanResource\Entities\Position;

class FunctionalDesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_functional_designations', ['only' => ['index']]);
        $this->middleware('permission:create_functional_designations', ['only' => ['create', 'store']]);
        $this->middleware('permission:update_functional_designations', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_functional_designations', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('humanresource::employee.functionalDesignation.index', [
            'functionalDesignations' => FunctionalDesignation::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'functional_designation' => 'required',
            'status' => 'required',
            'seniority_order' => 'required|numeric',
        ]);

        FunctionalDesignation::create($request->all());
        Toastr::success('Functional Designation added successfully :)','Success');
        return redirect()->route('functionalDesignation.index');
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'functional_designation' => 'required',
            'status' => 'required',
            'seniority_order' => 'required|numeric',
        ]);

        $functionalDesignation = FunctionalDesignation::where('uuid', $uuid)->firstOrFail();
        $functionalDesignation->update($request->all());
        Toastr::success('Functional Designation updated successfully :)','Success');
        return redirect()->route('functionalDesignation.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($uuid)
    {
        FunctionalDesignation::where('uuid' , $uuid)->delete();
        Toastr::success('Functional Designation deleted successfully :)','Success');
        return response()->json(['success' => 'success']);
    }
}

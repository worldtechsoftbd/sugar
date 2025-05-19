<?php

namespace Modules\Organization\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\HumanResource\Entities\Employee;
use Modules\Organization\App\Models\OrgOfficeHead;

class OrgOfficeHeadController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_org_office_head', ['only' => ['index', 'getShiftDetails']]);
        $this->middleware('permission:create_org_office_head', ['only' => ['store']]);
        $this->middleware('permission:edit_org_office_head', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_org_office_head', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orgOfficeHeads = OrgOfficeHead::all();

        return view('organization::orgOfficeHead.index', compact('orgOfficeHeads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createOrEdit($id = null)
    {
        $employees = Employee::all();

        return view('organization::orgOfficeHead.createOrEdit',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('organization::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('organization::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}

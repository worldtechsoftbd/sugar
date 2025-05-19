<?php

namespace Modules\Organization\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Organization\App\Models\Organization;
use Modules\Organization\App\Models\OrganizationOffices;

class OrganizationOfficeController extends Controller
{
    public function index()
    {
        $offices = OrganizationOffices::with('organization')->get();
        return view('organization::organizationOffices.index', compact('offices'));
    }

    public function create()
    {
        $organizations = Organization::all();
        return view('organization::organizationOffices.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'org_id' => 'required|exists:organization,id',
            'office_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'required|in:1,2,276',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:100|email',
        ]);

        OrganizationOffices::create($request->all());

        return redirect()->route('organization_offices.index')->with('success', 'Office created successfully.');
    }

    public function edit($id)
    {
        $office = OrganizationOffices::findOrFail($id);
        $organizations = Organization::all();
        return view('organization::organizationOffices.edit', compact('office', 'organizations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'org_id' => 'required|exists:organization,id',
            'office_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'required|in:1,2,276',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:100|email',
        ]);

        $office = OrganizationOffices::findOrFail($id);
        $office->update($request->all());

        return redirect()->route('organization_offices.index')->with('success', 'Office updated successfully.');
    }

    public function destroy($id)
    {
        $office = OrganizationOffices::findOrFail($id);
        $office->delete();

        return redirect()->route('organization_offices.index')->with('success', 'Office deleted successfully.');
    }
}

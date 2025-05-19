<?php

namespace Modules\Organization\App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Modules\Organization\App\Models\OrganizationOfficeDetails;
use Modules\Organization\App\Models\OrganizationOffices;

class OrganizationOfficeDetailsController extends Controller
{
    public function index()
    {
        $officeDetails = OrganizationOfficeDetails::with('organizationOffice')->get();
        return view('organization::organizationOfficesDetails.index', compact('officeDetails'));
    }

// Show a form to create a new office

    public function getOfficesByOrg(Request $request)
    {
        // Fetch organization office details by org_offices_id
        $orgOfficesId = $request->org_offices_id;
        $offices = OrganizationOfficeDetails::where('org_offices_id', $orgOfficesId)
            ->whereNull('deleted_at')
            ->get();
        return response()->json($offices);
    }
    public function create()
    {
        $orgOffices = OrganizationOffices::all(); // For dropdown of organizations
        return view('organization::organizationOfficesDetails.create', compact('orgOffices'));
    }

// Store a new office detail
    public function store(Request $request)
    {
        $request->validate([
            'org_offices_id' => 'required|exists:organization_offices,id',
            'office_name' => 'required|string|max:100',
            'address' => 'nullable|string|max:200',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:100',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'required|in:1,2,276',
            'sort_order' => 'nullable|integer',
            'is_parent' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:organization_office_details,id',
            'manager_name' => 'nullable|string|max:100',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|string|email|max:100',
            'notes' => 'nullable|string',
        ]);

        OrganizationOfficeDetails::create($request->all());

        return redirect()->route('organization_offices_details.index')->with('success', 'Office details created successfully.');
    }

// Show the form to edit an office detail
    public function edit($id)
    {
        $officeDetail = OrganizationOfficeDetails::findOrFail($id);
        $orgOffices = OrganizationOffices::all(); // For dropdown of organizations
        return view('organization::organizationOfficesDetails.edit', compact('officeDetail', 'orgOffices'));
    }

// Update an existing office detail
    public function update(Request $request, $id)
    {
        $request->validate([
            'org_offices_id' => 'required|exists:organization_offices,id',
            'office_name' => 'required|string|max:100',
            'address' => 'nullable|string|max:200',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:100',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'status' => 'required|in:1,2,276',
            'sort_order' => 'nullable|integer',
            'is_parent' => 'nullable|boolean',
            'parent_id' => 'nullable|exists:organization_office_details,id',
            'manager_name' => 'nullable|string|max:100',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|string|email|max:100',
            'notes' => 'nullable|string',
        ]);

        $officeDetail = OrganizationOfficeDetails::findOrFail($id);
        $officeDetail->update($request->all());

        return redirect()->route('organization_offices_details.index')->with('success', 'Office details updated successfully.');
    }

// Delete an office detail
    public function destroy($id)
    {
        $officeDetail = OrganizationOfficeDetails::findOrFail($id);
        $officeDetail->delete();

        return redirect()->route('organization_offices_details.index')->with('success', 'Office details deleted successfully.');
    }
}

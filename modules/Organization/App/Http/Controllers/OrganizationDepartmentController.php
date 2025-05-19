<?php

namespace Modules\Organization\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\HumanResource\Entities\Department;
use Modules\Organization\App\Models\Organization;
use Modules\Organization\App\Models\OrganizationDepartment;
use Modules\Organization\App\Models\OrganizationOffices;


class OrganizationDepartmentController extends Controller
{

    public function getLevel($parentId)
    {
        // Recursively determine the level of a department
        $level = 0;
        while ($parentId != 0) {
            $parent = OrganizationDepartment::find($parentId);
            if ($parent) {
                $parentId = $parent->parent_id;
                $level++;
            } else {
                break;
            }
        }

        return $level;
    }

    public function getDepartmentHierarchy($department)
    {
        $hierarchy = $department->department_name;  // Start with current department name

        // Check if there is a parent, if so, call the recursive function on the parent
        if ($department->parent) {
            $hierarchy = $this->getDepartmentHierarchy($department->parent) . ' - ' . $hierarchy;
        }

        return $hierarchy;
    }


    public function loadDepartmentHierarchy(Request $request): jsonResponse
    {
        $orgOfficeId = $request->input('org_office_id');

        $departments = OrganizationDepartment::where('org_offices_id', $orgOfficeId)
            ->with('parent') // Assuming you have a parent-child relationship defined
            ->get();

        $departmentHierarchies = $departments->map(function ($department) {
            return [
                'id' => $department->id,
                'hierarchy' => $this->getDepartmentHierarchy($department),
            ];
        });

        return response()->json($departmentHierarchies);
    }


    public function getOrganizationOfficesByOrganizationId($organizationId)
    {
        // Retrieve the organization offices based on the provided organization ID
        $organizationOffices = OrganizationOffices::where('org_id', $organizationId)->get();
        return $organizationOffices;
    }


    public function getDepartmentsByOrganizationId($organizationId)
    {
        // Join with organization_offices to filter by organization and get departments
        $departments = OrganizationDepartment::join('organization_offices', 'departments.org_offices_id', '=', 'organization_offices.id')
            ->where('organization_offices.org_id', $organizationId)
            ->select('departments.*')
            ->get();


        return $departments;
    }

    public function getParentDepartmentsByOrganizationOfficeId($organizationOfficeId)
    {
        // Join with organization_offices to filter by organization and get departments
        $departments = OrganizationDepartment::join('organization_offices', 'departments.org_offices_id', '=', 'organization_offices.id')
            ->where('organization_offices.org_id', $organizationOfficeId)
            ->where('organization_offices.parent_id', '')
            ->select('departments.*')
            ->get();


        return $departments;
    }


    public function index()
    {
        $departments = OrganizationDepartment::with('parent')->whereNull('deleted_at')->get();

        // Calculate the level for each department
        $parents = OrganizationDepartment::select('id', 'department_name', DB::raw('COALESCE(parent_id, 0) AS parent_id'))
            ->with('parent')
            ->get()
            ->map(function ($department) {
                $department->level = $this->getLevel($department->parent_id);
                return $department;
            });

        $departmentHierarchies = $parents->map(function ($parent) {
            return $this->getDepartmentHierarchy($parent);
        });
        return view('organization::organizationDepartments.index', compact('departments', 'departmentHierarchies'));
    }


    public function create()
    {
        $parents = OrganizationDepartment::select('id', 'department_name', DB::raw('COALESCE(parent_id, 0) AS parent_id'))
            ->with('parent')
            ->get()
            ->map(function ($department) {
                $department->level = $this->getLevel($department->parent_id);
                return $department;
            });

        $Organizations = Organization::all();

        $OrganizationOffices = OrganizationOffices::all();
        $departmentHierarchies = $parents->map(function ($parent) {
            return $this->getDepartmentHierarchy($parent);
        });

        return view('organization::organizationDepartments.create', compact('parents', 'Organizations', 'OrganizationOffices', 'departmentHierarchies'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'org_offices_id' => 'required|exists:organization_offices,id',
            'description' => 'nullable|string|max:200',
            'department_name' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'parent_id' => 'nullable|exists:departments,id',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:1,2,276',
            'is_active' => 'required|in:1,2',
        ]);

// Fetch department_name using the org_office relationship
//        $organizationOffice = OrganizationOffices::find($validated['org_offices_id']);
//        if ($organizationOffice) {
//            $validated['department_name'] = $organizationOffice->office_name;
//        } else {
//            // Handle the case where the organization office is not found
//            return back()->withErrors(['org_offices_id' => 'Invalid organization office selected.']);
//        }

// Generate a UUID
        $validated['uuid'] = Str::uuid();

// Create the record
        OrganizationDepartment::create($validated);


        return redirect()->route('organization-departments.index')->with('success', 'Department created successfully.');
    }


    public function edit(OrganizationDepartment $organizationDepartment)
    {
        // Fetch the selected organization office for the current department
        $selectedOrgOfficeId = $organizationDepartment->org_offices_id;

        // Fetch all organization offices
        $OrganizationOffices = OrganizationOffices::all();

        // Fetch the organization based on the selected office
        $Organizations = [];
        if ($selectedOrgOfficeId) {
            $selectedOffice = OrganizationOffices::where('id', $selectedOrgOfficeId)->first();
            if ($selectedOffice) {
                $Organizations = Organization::where('id', $selectedOffice->org_id)->get();
            }
        }

        // Fetch parents based on the selected organization office
        $parents = OrganizationDepartment::select('id', 'department_name', 'parent_id', 'org_offices_id')
            ->where('org_offices_id', $selectedOrgOfficeId) // Filter by selected organization office
            ->with('parent') // Load parent relationships
            ->get()
            ->map(function ($department) {
                $department->level = $this->getLevel($department->parent_id);
                return $department;
            });

        // Generate department hierarchies
        $departmentHierarchies = $parents->map(function ($parent) {
            return $this->getDepartmentHierarchy($parent);
        });

        return view('organization::organizationDepartments.edit', compact(
            'organizationDepartment',
            'Organizations',
            'OrganizationOffices',
            'departmentHierarchies',
            'parents'
        ));
    }



    public function update(Request $request, OrganizationDepartment $organizationDepartment)
    {
        $validated = $request->validate([
            'department_name' => 'required|string|max:191',
            'description' => 'nullable|string|max:200',
            'address' => 'nullable|string|max:200',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'parent_id' => 'nullable|exists:departments,id',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'status' => 'required|in:1,2,276',
        ]);

        $organizationDepartment->update($validated);

        return redirect()->route('organization-departments.index')->with('success', 'Department updated successfully.');
    }

    public function destroy(OrganizationDepartment $organizationDepartment)
    {
        $organizationDepartment->delete();
        return redirect()->route('organization-departments.index')->with('success', 'Department deleted successfully.');
    }
}

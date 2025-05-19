<?php

namespace Modules\Attendance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Attendance\Entities\EmployeeShift;
use Modules\Attendance\Entities\MillShift;
use Modules\HumanResource\Entities\Department;
use Modules\HumanResource\Entities\Employee;
use Modules\Organization\App\Models\Organization;
use Modules\Organization\App\Models\OrganizationOffices;

class EmployeeShiftController extends Controller
{
    public function index()
    {
        //dd('working');
        $employeeShifts = EmployeeShift::with('employee', 'millShift')->get();
        return view('attendance::employee_shifts.index', compact('employeeShifts'));
    }
    public function getEmployeesByOrganization(Request $request)
    {
        $department_id = $request->department_id;
        if (is_array($department_id)) {

            $employees = Employee::whereIn('department_id', $department_id)
                ->whereNotIn('id', function ($query) {
                    $query->select('employee_id')->from('employee_shifts');
                })
                ->get();
            return response()->json($employees);
        } else {
            return response()->json(['error' => 'Invalid input format'], 400);
        }

    }


    public function create()
    {
        $employees = Employee::all();
        $organizations  = Organization::all();
        $millShifts = MillShift::all();
        return view('attendance::employee_shifts.create', compact('employees', 'millShifts','organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_ids' => 'required|array|min:1', // Ensure it's an array and has at least one item
//            'mill_shift_id' => 'required|exists:mill_shifts,id',
            'shift_date' => 'required|date',
        ]);

        if (in_array('all', $request->employee_ids)) {
            $employeeIds = Employee::pluck('id')->toArray();
        } else {
            if (is_string($request->employee_ids[0])) {
                $employeeIds = explode(',', $request->employee_ids[0]); // Convert string to array
            } else {
                $employeeIds = $request->employee_ids; // Already an array
            }
            $request->validate([
                'employee_ids.*' => 'exists:employees,id',
            ]);
        }

        foreach ($employeeIds as $employee_id) {
            $existingShift = EmployeeShift::where('employee_id', $employee_id)
//                ->where('shift_date', $request->shift_date)
                ->first();

            if ($existingShift) {
                return back()->with('success', 'Employee ' . $employee_id . ' already has a shift assigned for this date.');
            }

            EmployeeShift::create([
                'employee_id' => $employee_id,
                'mill_shift_id' => $request->mill_shift_id,
                'shift_date' => $request->shift_date,
            ]);

        }

        return redirect()->route('employee-shifts.index')->with('success', 'Shift(s) assigned successfully.');
    }


    public function edit($id)
    {
        $employeeShift = EmployeeShift::findOrFail($id);
        $organizations = Organization::all();
        $millShifts = MillShift::with('department', 'shift')->get();

        $employees = Employee::where('department_id', $employeeShift->organization_id)->get();
        $selectedEmployees = $employeeShift->employee_ids; // Use the relationship or field storing IDs

        return view('attendance::employee_shifts.edit', compact(
            'employeeShift',
            'organizations',
            'millShifts',
            'employees',
            'selectedEmployees'
        ));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_ids' => 'required|array|min:1',
            'mill_shift_id' => 'required|exists:mill_shifts,id',
            'shift_date' => 'required|date',
        ]);

        $employeeShift = EmployeeShift::findOrFail($id);

        // Update fields
        $employeeShift->update([
            'mill_shift_id' => $request->mill_shift_id,
            'shift_date' => $request->shift_date,
        ]);

        // Sync employees
        $employeeShift->employees()->sync($request->employee_ids);

        return redirect()->route('employee-shifts.index')->with('success', 'Employee shift updated successfully.');
    }


    public function destroy(EmployeeShift $employeeShift)
    {
        $employeeShift->delete();
        return redirect()->route('employee-shifts.index')->with('success', 'Employee shift deleted successfully.');
    }

    public function getDepartments(Request $request)
    {
        $officeIds = $request->office_ids; // Expecting an array of office IDs
        if (is_array($officeIds)) {
            $departments = Department::whereIn('org_offices_id', $officeIds)->get(['id', 'department_name']);
            return response()->json($departments);
        } else {
            return response()->json(['error' => 'Invalid input format'], 400);
        }
    }
    public function getShifts(Request $request)
    {
        $officeIds = $request->office_ids; // Expecting an array of office IDs

        if (is_array($officeIds)) {
            // Eager load the related shift and retrieve the shift names
            $shifts = MillShift::with('shift')
                ->whereIn('mill_id', $officeIds)
                ->get()
                ->map(function ($millShift) {
                    return [
                        'shift_id' => $millShift->shift_id,
                        'name' => $millShift->shift ? $millShift->shift->name : 'Unnamed Shift', // Get name from Shift model
                    ];
                });

            return response()->json($shifts);
        } else {
            return response()->json(['error' => 'Invalid input format'], 400);
        }
    }


    public function getOffices(Request $request)
    {
        $organization_id = $request->organization_id;
        $offices = OrganizationOffices::where('org_id', $organization_id)->get(['id', 'office_name']);
        return response()->json($offices);
    }
}

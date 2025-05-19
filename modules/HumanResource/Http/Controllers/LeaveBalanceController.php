<?php

namespace Modules\HumanResource\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\HumanResource\Entities\Employee;
use Modules\HumanResource\Entities\LeaveType;
use Modules\HumanResource\Entities\EmployeeLeaveBalance;
use Modules\HumanResource\Entities\EmployeeLeaveBalanceHistory;
use Modules\HumanResource\DataTables\LeaveBalanceDataTable;

class LeaveBalanceController extends Controller
{
    public function index(LeaveBalanceDataTable $dataTable)
    {
        $employees = Employee::where('is_active', 1)->get();
        $leaveTypes = LeaveType::all();

        $leaveBalances = [];

        foreach ($employees as $employee) {
            foreach ($leaveTypes as $leaveType) {
                $balance = EmployeeLeaveBalance::where('emp_id', $employee->id)
                    ->where('leave_type_id', $leaveType->id)
                    ->first();

                $leaveBalances[$employee->id][$leaveType->id] = $balance ? $balance->leave_balance : 0;
            }
        }

        // Pass the dataTable instance to the view

//        dd($leaveBalances); // Debugging line


        // Return the view with the leave balances
        return view('humanresource::leave.leave-balance.leave_balance_index', compact('employees', 'leaveTypes', 'leaveBalances'));
    }


    // Show the leave balance form
    public function showLeaveBalanceForm()
    {
        // Get all active employees and leave types
        $employees = Employee::where('is_active', 1)->get();
        $leaveTypes = LeaveType::all();

        return view('humanresource::leave.leave-balance.leave_balance_form', compact('employees', 'leaveTypes'));
    }

    // Update employee leave balance
    public function updateLeaveBalance(Request $request)
    {

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'leave_balance' => 'required|numeric|min:0',
        ]);

        // Find the employee and leave type
        $employee = Employee::find($request->employee_id);
        $leaveType = LeaveType::find($request->leave_type_id);

        // Update the leave balance record
        $leaveBalance = EmployeeLeaveBalance::updateOrCreate(
            ['emp_id' => $employee->id, 'leave_type_id' => $leaveType->id],
            ['leave_balance' => $request->leave_balance]
        );

        // Add a record in the history table
        EmployeeLeaveBalanceHistory::create([
            'emp_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'change' => $request->leave_balance - $leaveBalance->getOriginal('leave_balance'),
            'balance_after_change' => $leaveBalance->leave_balance,
            'action' => 'Updated',
        ]);

        Toastr::success('Update Successfully :)', 'Success');
        return response()->json(['success' => true, 'message' => 'Leave balance updated successfully!']);
    }

    public function insertLeaveBalanceForAll(Request $request)
    {
        EmployeeLeaveBalance::truncate();
        EmployeeLeaveBalanceHistory::truncate();


        $currentYear = date('Y');

        $leaveTypes = LeaveType::all();
        $employees = Employee::where('is_active', 1)->get();

        foreach ($employees as $employee) {
            foreach ($leaveTypes as $leaveType) {

                $existingLeaveBalance = EmployeeLeaveBalance::where('emp_id', $employee->id)
                    ->where('leave_type_id', $leaveType->id)
                    ->where('leave_year', $currentYear)
                    ->first();

                // If a record exists, skip the insertion for this employee, leave type, and year
                if ($existingLeaveBalance) {
                    continue;  // Skip this iteration if the record already exists
                }

                // Insert or update the leave balance for each employee and leave type
                $leaveBalance = EmployeeLeaveBalance::create([
                    'emp_id' => $employee->id,
                    'leave_year' => $currentYear,
                    'leave_type_id' => $leaveType->id,
                    'leave_balance' => $leaveType->leave_days,  // Initial balance
                    'leave_spent' => 0,    // Initial spent balance
                    'cr_leave_balance' => $leaveType->leave_days, // Carry forward balance
                    'status' => 'active',
                ]);

                // Log the insertion in history
//                EmployeeLeaveBalanceHistory::create([
//                    'emp_id' => $employee->id,  // This should still use employee_id for logging
//                    'leave_type_id' => $leaveType->id,
//                    'change' => 0,  // No initial balance, so 0
//                    'balance_after_change' => $leaveBalance->leave_balance,
//                    'action' => 'Inserted',
//                ]);
            }
        }

        Toastr::success('Insert Successfully :)', 'Success');
        return response()->json([
            'success' => true,
            'message' => localize('leave_balance_inserted_for_all_employees')
        ]);
    }


    public function getLeaveBalance(Request $request)
    {
        $employeeId = $request->employee_id;
        $leaveTypeId = $request->leave_type_id;
        $currentYear = date('Y');  // Use current year

        // Get the leave balance record for the selected employee and leave type
        $leaveBalanceRecord = EmployeeLeaveBalance::where('emp_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('leave_year', $currentYear)
            ->first();

        // If record exists, return the balance
        if ($leaveBalanceRecord) {
            return response()->json([
                'success' => true,
                'leave_balance' => $leaveBalanceRecord->leave_balance - $leaveBalanceRecord->leave_spent,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No leave balance found for this employee and leave type.',
            ]);
        }
    }
}

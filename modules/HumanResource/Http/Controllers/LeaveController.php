<?php

namespace Modules\HumanResource\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Accounts\Entities\FinancialYear;
use Modules\HumanResource\DataTables\LeaveApplicationDataTable;
use Modules\HumanResource\Entities\ApplyLeave;
use Modules\HumanResource\Entities\Employee;
use Modules\HumanResource\Entities\EmployeeLeaveBalance;
use Modules\HumanResource\Entities\LeaveType;
use Modules\HumanResource\Entities\LeaveTypeYear;
use Modules\HumanResource\Entities\WeekHoliday;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_weekly_holiday')->only('weekleave');
        $this->middleware('permission:update_weekly_holiday')->only(['weekleave_edit', 'weekleave_update']);
        $this->middleware('permission:read_leave_type')->only(['leaveTypeindex']);

        $this->middleware('permission:update_leave_generate')->only(['leaveGenerate', 'generateLeave']);
        $this->middleware('permission:read_leave_generate')->only(['generateLeaveDetail']);

        $this->middleware('permission:read_leave_application')->only('index', 'show');
        $this->middleware('permission:create_leave_application')->only('create');
        $this->middleware('permission:update_leave_application')->only('edit', 'update');
        $this->middleware('permission:delete_leave_application')->only('destroy');

        $this->middleware('permission:create_leave_approval')->only('approved');
        $this->middleware('permission:read_leave_approval')->only('leaveApproval');
    }

    public function weekleave()
    {
        $dbData = WeekHoliday::all();
        return view('humanresource::leave.weekholiday', compact('dbData'));
    }
    public function weekleave_edit($uuid)
    {
        $dbData = WeekHoliday::where('uuid', $uuid)->first();
        $days = $dbData->dayname;
        $days = explode(',', $days);
        return view('humanresource::leave.weekholiday_edit', compact('dbData', 'days'));
    }

    public function weekleave_update(Request $request, WeekHoliday $weeklyholiday)
    {
        $request->validate([
            "dayname" => 'required',
        ]);

        $weeklyholiday->dayname = implode(",", $request->dayname);
        $weeklyholiday->save();

        Toastr::success('Update Successfully :)', 'Success');
        return redirect()->route('leave.weekleave.edit', $weeklyholiday->uuid);
    }
    public function leaveTypeindex()
    {
        $dbData = LeaveType::all();
        return view('humanresource::leave.leavetypeindex', compact('dbData'));
    }
    public function leaveGenerate()
    {
        $yearData = LeaveTypeYear::all()->groupBy('academic_year_id');
        $yearKeys = $yearData->keys();
        $dbData = FinancialYear::findOrFail($yearKeys);
        $accYear = FinancialYear::where('status', 1)->get();
        return view('humanresource::leave.leavegenerateindex', compact('accYear', 'dbData'));
    }

    public function generateLeave(Request $request)
    {
        $request->validate([
            'academic_year_id' => 'required',
        ]);

        $yearId = $request->academic_year_id;

        $current_date_time = Carbon::now()->toDateTimeString();
        $employee = Employee::where('is_active', 1)->get();
        $leaveType = LeaveType::all();

        foreach ($employee as $eKey => $employeeValue) {
            $existingRecords = LeaveTypeYear::where('employee_id', $employeeValue->id)
                ->where('academic_year_id', $yearId)
                ->exists();

            if ($existingRecords) {
                continue;
            }

            foreach ($leaveType as $lkey => $leaveTypeValue) {
                $insertData[$lkey]['employee_id'] = $employeeValue->id;
                $insertData[$lkey]['leave_type_id'] = $leaveTypeValue->id;
                $insertData[$lkey]['academic_year_id'] = $yearId;
                $insertData[$lkey]['entitled'] = $leaveTypeValue->leave_days;
                $insertData[$lkey]['created_by'] = Auth::id();
                $insertData[$lkey]['created_at'] = $current_date_time;
                $insertData[$lkey]['updated_at'] = $current_date_time;
                $insertData[$lkey]['uuid'] = Str::uuid();
            }
            LeaveTypeYear::insert($insertData);
        }

        return redirect()->route('leave.leaveGenerate')->with('success', localize('leave_generate_successfully'));
    }

    public function generateLeaveDetail($yearId)
    {
        $dbData = LeaveTypeYear::where('academic_year_id', $yearId)->get();

        return view('humanresource::leave.leavegeneratedetail', compact('dbData'));
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(LeaveApplicationDataTable $dataTable)
    {


        $leaveTypes = LeaveType::all();
//        $employees = Employee::where('is_active', 1)->get();
        $user = auth()->user();
//        dd($user->user_type_id);
        $officeHead = DB::table('org_office_head')
            ->where('emp_id', $user->id)
            ->first();

        if ($officeHead ) {
            $employees = Employee::where('is_active', 1)
                ->where('department_id', $officeHead->org_office_id)
                ->get();
        }
        elseif ($user->user_type_id == 1)
        {
            $employees = Employee::where('is_active', 1)
                ->get();
        }
        else {
            $employees = Employee::where('is_active', 1)
                ->where('id', $user->id)
                ->get();
        }



        return $dataTable->render('humanresource::leave.leaveapplication', compact('employees', 'leaveTypes'));
    }

//    public function store(Request $request)
//    {
//        $path = '';
//
//        $validated = $request->validate([
//            'employee_id' => 'required',
//            'leave_type_id' => 'required',
//            'leave_apply_start_date' => 'required',
//            'leave_apply_end_date' => 'required',
//            'total_apply_day' => 'required',
//            'reason' => '',
//
//        ]);
//
//        $year = Carbon::createFromFormat('Y-m-d', $request->leave_apply_start_date)->format('Y');
//
//        if ($request->hasFile('location')) {
//            $request_file = $request->file('location');
//            $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
//            $path = $request_file->storeAs('leave', $filename, 'public');
//        }
//
//        $validated['location'] = $path;
//        $validated['leave_apply_date'] = Carbon::now()->toDateTimeString();
//
//        ApplyLeave::create($validated);
//
//        return redirect()->route('leave.index')->with('success', localize('data_save'));
//    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'leave_apply_start_date' => 'required',
            'leave_apply_end_date' => 'required',
            'total_apply_day' => 'required',
            'reason' => '',
        ]);

        // Get the requested leave type and employee's leave balance for the current year
        $employeeId = $request->employee_id;
        $leaveTypeId = $request->leave_type_id;
        $requestedLeaveDays = $request->total_apply_day;
        $currentYear = Carbon::createFromFormat('Y-m-d', $request->leave_apply_start_date)->format('Y');

        // Get the employee's leave balance for the requested leave type and current year
        $leaveBalanceRecord = EmployeeLeaveBalance::where('emp_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('leave_year', $currentYear)
            ->first();

        // Check if the leave balance record exists
        if (!$leaveBalanceRecord) {
            Toastr::error('No leave balance found for the selected leave type.', 'Error');
            return back();
        }

        // Calculate the available leave balance
        $availableLeaveBalance = $leaveBalanceRecord->leave_balance - $leaveBalanceRecord->leave_spent;

        // Check if the requested leave days are within the available balance
        if ($requestedLeaveDays > $availableLeaveBalance) {
            Toastr::error('Insufficient leave balance for the requested leave days.', 'Error');
            return back();
        }

        // Handle the file upload for the leave application (if any)
        $path = '';
        if ($request->hasFile('location')) {
            $request_file = $request->file('location');
            $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
            $path = $request_file->storeAs('leave', $filename, 'public');
        }

        // Create the leave application record
        $validated['location'] = $path;
        $validated['leave_apply_date'] = Carbon::now()->toDateTimeString();

        // Create the leave application
        ApplyLeave::create($validated);

        // Update the employee's leave balance to reflect the spent days
        $leaveBalanceRecord->leave_spent += $requestedLeaveDays;
        $leaveBalanceRecord->save();

        // Success message using Toastr
        Toastr::success('Leave application submitted successfully!', 'Success');
        return redirect()->route('leave.index');
    }

    public function leaveApplicationEdit($id)
    {
        $row = ApplyLeave::findOrFail($id);
        $leaveTypes = LeaveType::all();
        $employees = Employee::where('is_active', 1)->get();
        return response()->view('humanresource::leave.livedit', compact('row', 'employees', 'leaveTypes'));
    }

    public function showApproveLeaveApplication($id)
    {
        $row = ApplyLeave::findOrFail($id);
        return response()->view('humanresource::leave.approveleave', compact('row'));
    }

    public function update(Request $request, ApplyLeave $leave)
    {
        $path = '';

        $validated = $request->validate([
            'employee_id' => 'required',
            'leave_type_id' => 'required',
            'leave_apply_start_date' => 'required',
            'leave_apply_end_date' => 'required',
            'total_apply_day' => 'required',
            'reason' => '',

        ]);

        $year = Carbon::createFromFormat('Y-m-d', $request->leave_apply_start_date)->format('Y');
        $validated['academic_year_id'] = $year;

        if ($request->hasFile('location')) {
            $request_file = $request->file('location');
            $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
            $path = $request_file->storeAs('leave', $filename, 'public');
        } else {
            $path = $request->oldlocation;
        }

        $validated['location'] = $path;
        $validated['leave_apply_date'] = Carbon::now()->toDateTimeString();

        $leave->update($validated);

        return redirect()->route('leave.index')->with('update', localize('data_update'));
    }

    public function approved(Request $request, ApplyLeave $leave)
    {

        $validated = $request->validate([

            'leave_approved_start_date' => 'required',
            'leave_approved_end_date' => 'required',
            'total_approved_day' => 'required',

        ]);

        $validated['approved_by'] = Auth::id();

        DB::transaction(function () use ($validated, $leave, $request) {
            $validated['is_approved'] = 1;
            $validated['leave_approved_date'] = Carbon::now()->toDateTimeString();
            $leave->update($validated);
            LeaveTypeYear::where('employee_id', $leave->employee_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->where('academic_year_id', $leave->academic_year_id)
                ->update(['taken' => $request->total_approved_day]);
        });
        $employeeLeaveBalance = EmployeeLeaveBalance::where('emp_id', $leave->employee_id)
            ->where('leave_type_id', $leave->leave_type_id)
            ->first();

        if ($employeeLeaveBalance) {
            $employeeLeaveBalance->leave_balance -= $request->total_approved_day;
            $employeeLeaveBalance->leave_spent += $request->total_approved_day;
            $employeeLeaveBalance->save();
        }


        return redirect()->route('leave.index')->with('success', localize('leave_approved_successfully'));
    }

    public function leaveApproval()
    {
        $leaves = ApplyLeave::where('is_approved_by_manager', false)->paginate(30);

        return view('humanresource::leave.leave-approval', [
            'leaves' => $leaves,
        ]);
    }

    public function ApprovedByManager(Request $request, $uuid)
    {
        $request->validate([
            "leave_approved_start_date" => 'required',
            "leave_approved_end_date" => 'required',
            "total_approved_day" => 'required',
        ]);

        $leave = ApplyLeave::where('uuid', $uuid)->firstOrFail();
        $leave->is_approved_by_manager = 1;
        $leave->manager_approved_description = $request->description;
        $leave->approved_by_manager = auth()->id();
        $leave->manager_approved_date = Carbon::now()->toDateTimeString();
        $leave->update();

        Toastr::success('Leave Application Approved :)', 'Success');
        return redirect()->route('leave.approval')->with('update', localize('data_update'));
    }

    public function destroy(ApplyLeave $leave)
    {
        $leave->delete();
        Toastr::success('Leave Application Deleted successfully :)', 'Success');
        return response()->json(['success' => 'success']);
    }
}

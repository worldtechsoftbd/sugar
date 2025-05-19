<?php

namespace Modules\Payroll\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Modules\HumanResource\Entities\Employee;
use Modules\Payroll\App\Models\EmpPaidDayCount;
use Modules\Payroll\App\Models\PayrollInfo;
use Yajra\DataTables\DataTables;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = PayrollInfo::with('employee')->orderBy('created_at', 'desc')->get();
        return view('payroll::PayrollInfo.index', compact('payrolls'));
    }

    public function createOrUpdate($id = null)
    {
        $employees = Employee::all();
        $payroll = $id ? PayrollInfo::findOrFail($id) : null;
        return view('payroll::PayrollInfo.createOrUpdate', compact('employees', 'payroll'));
    }

    public function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'emp_id' => [
                'required',
                'exists:employees,id',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = PayrollInfo::where('emp_id', $value)
                        ->when($id, function ($query) use ($id) {
                            return $query->where('id', '!=', $id);
                        })
                        ->exists();

                    if ($exists) {
                        $fail(localize('This employee already has a payroll entry.'));
                    }
                }
            ],
            'payrollId' => [
                'required',
                'string',
                'max:30',
                function ($attribute, $value, $fail) use ($id) {
                    $exists = PayrollInfo::where('payrollId', $value)
                        ->when($id, function ($query) use ($id) {
                            return $query->where('id', '!=', $id);
                        })
                        ->exists();

                    if ($exists) {
                        $fail(localize('The payroll ID is already in use.'));
                    }
                }
            ],
        ]);

        PayrollInfo::updateOrCreate(
            ['id' => $id],
            [
                'uuid' => $id ? PayrollInfo::find($id)->uuid : (string)Str::uuid(),
                'emp_id' => $request->emp_id,
                'payrollId' => $request->payrollId,
                'remarks' => $request->remarks,
                'status' => 101,
            ]
        );

        return redirect()->route('payroll.index')->with('success', localize('Payroll information saved successfully.'));
    }


    public function dayCountIndex()
    {
        return view('payroll::PayrollInfo.dayCount');
    }

    public function processDayCount(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
        ]);

        $paymentDate = Carbon::parse($request->payment_date); // Use given date, not the end of the month
        $yearMonth = $paymentDate->format('Y-m');

        // Fetch only employees who have an entry in PayrollInfo
        $employees = Employee::where('is_active', 1)
            ->whereHas('payrollInfo') // Ensure employee has a payroll entry
            ->with('payrollInfo') // Load payroll info
            ->get();

        foreach ($employees as $employee) {
            $payrollId = $employee->payrollInfo->id; // Ensure payroll ID is fetched correctly

            // ✅ FIX: Default date should be the 1st of the month or the joining date
            $defaultDate = $employee->joining_date
                ? Carbon::parse($employee->joining_date)
                : $paymentDate->copy()->startOfMonth();

            // ✅ FIX: End date should be the given payment date, not the last date of the month
            $endDate = $paymentDate->endOfMonth();

            // ✅ FIX: Correctly calculate day count (number of working days from default_date to payment_date)
            $dayCount = $defaultDate->diffInDays($endDate) + 1; // Including the payment date

            $empStatus = $employee->is_active ? 1 : 2;

            EmpPaidDayCount::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'year_month' => $yearMonth,
                ],
                [
                    'uuid' => \Str::uuid(),
                    'payroll_id' => $payrollId, // Use payroll ID from PayrollInfo
                    'payment_date' => $request->payment_date,
                    'default_date' => $defaultDate,
                    'day_count' => $dayCount,
                    'day_paid' => $dayCount,
                    'is_paid' => 1,
                    'status' => 1,
                    'ready_to_pay' => 1,
                    'end_date' => $endDate,
                    'remarks' => 'Auto-generated Salary Day Count',
                    'emp_status' => $empStatus,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Salary Day Count Processed Successfully');
    }


    public function listDayCount(Request $request)
    {
        $query = EmpPaidDayCount::with('employee')->select('emp_paid_day_count.*');

        if ($request->has('year_month')) {
            $query->where('year_month', $request->year_month);
        }

        return DataTables::of($query)
            ->addColumn('employee_name', function ($row) {
                return $row->employee->first_name . ' ' . $row->employee->last_name;
            })
            ->addColumn('actions', function ($row) {
                return '<button class="btn btn-sm btn-info edit-btn" data-id="' . $row->id . '">Edit</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function editDayCount($id)
    {
        $dayCount = EmpPaidDayCount::with('employee')->findOrFail($id);

        return response()->json([
            'id' => $dayCount->id,
            'employee_name' => $dayCount->employee->first_name . ' ' . $dayCount->employee->last_name,
            'year_month' => $dayCount->year_month,
            'day_count' => $dayCount->day_count,
            'day_paid' => $dayCount->day_paid,
            'remarks' => $dayCount->remarks,
            'status' => $dayCount->status
        ]);
    }

    public function updateDayCount(Request $request, $id)
    {
        $request->validate([
            'day_count' => 'required|integer|min:0',
            'day_paid' => 'required|integer|min:0',
            'remarks' => 'nullable|string|max:150',
            'status' => 'required|integer'
        ]);

        $dayCount = EmpPaidDayCount::findOrFail($id);
        $dayCount->update([
            'day_count' => $request->day_count,
            'day_paid' => $request->day_paid,
            'remarks' => $request->remarks,
            'status' => $request->status,
            'updated_by' => auth()->id()
        ]);

        return response()->json(['success' => 'Salary Day Count updated successfully']);
    }


}

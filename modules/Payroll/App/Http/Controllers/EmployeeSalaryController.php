<?php

namespace Modules\Payroll\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\HumanResource\Entities\Employee;
use Modules\Payroll\App\Models\EmployeeSalary;
use Modules\Payroll\App\Models\PaymentOrDeductionTypes;
use Modules\Payroll\App\Models\PayrollInfo;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payroll::EmployeeSalary.index');
    }

    public function paymentSetup()
    {
        // Fetch employees for the dropdown
        $employees = Employee::all();

        // Fetch payment types where pay_or_ded = 1
        $paymentTypes = PaymentOrDeductionTypes::where('pay_or_ded', 1)->orderby('id', 'asc')->get();

        // Fetch deduction types where pay_or_ded = 2
        $deductionTypes = PaymentOrDeductionTypes::where('pay_or_ded', 2)->orderby('id', 'asc')->get();

        return view('payroll::EmployeeSalary.payment-setup', compact('employees', 'paymentTypes', 'deductionTypes'));
    }

    public function storePaymentSetup(Request $request)
    {

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'payments' => 'array',
            'deductions' => 'array',
        ]);

        DB::transaction(function () use ($request) {
            $payroll = PayrollInfo::where('emp_id', $request->employee_id)->firstOrFail();


            // Handle Payments
            if ($request->has('payments')) {
                foreach ($request->payments as $type_id => $amount) {

                    EmployeeSalary::create([
                        'uuid' => (string)Str::uuid(),
                        'emp_id' => $request->employee_id,
                        'payroll_info_id' => $payroll->id,
                        'pay_or_ded' => 1,
                        'type_id' => $type_id,
                        'amount' => $amount ?? 0,
                        'status' => 101
                    ]);

                }
            }

            // Handle Deductions
            if ($request->has('deductions')) {
                foreach ($request->deductions as $type_id => $amount) {

                    EmployeeSalary::create([
                        'uuid' => (string)Str::uuid(),
                        'emp_id' => $request->employee_id,
                        'payroll_info_id' => $payroll->id,
                        'pay_or_ded' => 2,
                        'type_id' => $type_id,
                        'amount' => $amount ?? 0,
                        'status' => 101
                    ]);

                }
            }
        });

        return redirect()->back()->with('success', 'Payment setup saved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('payroll::create');
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
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('payroll::edit');
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

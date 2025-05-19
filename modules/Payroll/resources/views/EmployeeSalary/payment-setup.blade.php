@extends('backend.layouts.app')

@section('title', 'Employees Salary Setup')

@section('content')
    <div class="container">
        <h4 class="mb-3 text-center">Employee Payment Setup</h4>

        <form action="{{ route('payroll.paymentSetup.store') }}" method="POST" class="card shadow-sm p-3">
            @csrf
            <div class="mb-2">
                <label for="employee" class="form-label fw-semibold">Employee</label>
                <select name="employee_id" id="employee" class="form-select form-select-sm select2">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->first_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="row g-2">
                <!-- Payment Types Section -->
                <div class="col-md-6">
                    <h6 class="text-center">Payment Types</h6>
                    <div class="p-2 border rounded bg-light">
                        @foreach($paymentTypes as $payment)
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label fw-semibold me-2 mb-0" style="flex: 1;">{{ $payment->description }}</label>
                                <input type="number" class="form-control form-control-sm" name="payments[{{ $payment->id }}]" placeholder="Amount" style="width: 100px;">
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Deduction Types Section -->
                <div class="col-md-6">
                    <h6 class="text-center">Deduction Types</h6>
                    <div class="p-2 border rounded bg-light">
                        @foreach($deductionTypes as $deduction)
                            <div class="mb-2 d-flex align-items-center">
                                <label class="form-label fw-semibold me-2 mb-0" style="flex: 1;">{{ $deduction->description }}</label>
                                <input type="number" class="form-control form-control-sm" name="deductions[{{ $deduction->id }}]" placeholder="Amount" style="width: 100px;">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-3 text-center">
                <button type="submit" class="btn btn-success btn-sm px-3">Submit</button>
                <a href="{{ route('payroll.index') }}" class="btn btn-danger btn-sm px-3">Back</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select2 Initialization
            $('.select2').select2({
                placeholder: 'Select an option',
                allowClear: true,
            });
        });
    </script>
@endsection

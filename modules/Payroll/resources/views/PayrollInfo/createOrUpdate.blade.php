@extends('backend.layouts.app')

@section('title', isset($payroll) ? localize('Edit Payroll Info') : localize('Create Payroll Info'))

@section('content')
    <div class="container d-flex justify-content-center mt-4">
        <div class="card shadow-sm p-4" style="width: 50%; min-width: 400px;">
            <h5 class="mb-3 text-center">{{ isset($payroll) ? localize('Edit Payroll Info') : localize('Create Payroll Info') }}</h5>
            <form action="{{ isset($payroll) ? route('payroll.update', $payroll->id) : route('payroll.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="emp_id" class="form-label fw-semibold">{{ localize('Employee') }}</label>
                    <select name="emp_id" id="emp_id" class="form-select form-select-sm select2 @error('emp_id') is-invalid @enderror">
                        <option value="">{{ localize('Select Employee') }}</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('emp_id', isset($payroll) ? $payroll->emp_id : '') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }}</option>
                        @endforeach
                    </select>
                    @error('emp_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="payrollId" class="form-label fw-semibold">{{ localize('Payroll ID') }}</label>
                    <input type="text" class="form-control form-control-sm @error('payrollId') is-invalid @enderror" id="payrollId" name="payrollId" value="{{ old('payrollId', isset($payroll) ? $payroll->payrollId : '') }}">
                    @error('payrollId')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label fw-semibold">{{ localize('Remarks') }}</label>
                    <textarea class="form-control form-control-sm" id="remarks" name="remarks" rows="2">{{ old('remarks', isset($payroll) ? $payroll->remarks : '') }}</textarea>
                </div>
                <div class="mt-3 text-center">
                    <button type="submit" class="btn btn-success btn-sm px-4">{{ isset($payroll) ? localize('Update') : localize('Create') }}</button>
                    <a href="{{ route('payroll.index') }}" class="btn btn-secondary btn-sm px-4">{{ localize('Back') }}</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select2 Initialization
            $('.select2').select2({
                placeholder: '{{ localize('Select an option') }}',
                allowClear: true,
                minimumResultsForSearch: Infinity
            });
        });
    </script>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Manage Employee Leave Balance</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form to select employee, leave type, and update leave days -->
        <form action="{{ route('leave_balance.update') }}" method="POST">
            @csrf

            <!-- Employee selection -->
            <div class="form-group">
                <label for="employee_id">Select Employee</label>
                <select name="employee_id" id="employee_id" class="form-control" required>
                    <option value="" disabled selected>Select an Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Leave Type selection -->
            <div class="form-group">
                <label for="leave_type_id">Select Leave Type</label>
                <select name="leave_type_id" id="leave_type_id" class="form-control" required>
                    <option value="" disabled selected>Select Leave Type</option>
                    @foreach($leaveTypes as $leaveType)
                        <option value="{{ $leaveType->id }}">{{ $leaveType->type_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Leave Days input -->
            <div class="form-group">
                <label for="leave_days">Leave Days</label>
                <input type="number" name="leave_days" id="leave_days" class="form-control" required>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Update Leave Balance</button>
        </form>
    </div>
@endsection
